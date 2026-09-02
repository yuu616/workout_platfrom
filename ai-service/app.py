"""大肌肌健身平台 - AI 菜單生成服務。

只負責呼叫 Gemini 產生菜單並回傳，不碰資料庫：
菜單的儲存由 PHP 端的 save_response.php 負責，那裡的 user_id 取自 session，
不像這裡是由前端送上來的，比較不會被偽造。
"""

import os

from flask import Flask, request, jsonify
from flask_cors import CORS
import google.generativeai as genai

app = Flask(__name__)
CORS(app)  # 啟用CORS支持

# 配置 Google Generative AI 服務。
# API 金鑰請以環境變數 GEMINI_API_KEY 提供，不要寫死在程式碼裡。
genai.configure(api_key=os.environ.get("GEMINI_API_KEY", ""))

generation_config = {
    "temperature": 1,
    "top_p": 0.95,
    "top_k": 0,
    "max_output_tokens": 2048,
}

safety_settings = [
    {
        "category": "HARM_CATEGORY_HARASSMENT",
        "threshold": "BLOCK_MEDIUM_AND_ABOVE"
    },
    {
        "category": "HARM_CATEGORY_HATE_SPEECH",
        "threshold": "BLOCK_MEDIUM_AND_ABOVE"
    },
    {
        "category": "HARM_CATEGORY_SEXUALLY_EXPLICIT",
        "threshold": "BLOCK_MEDIUM_AND_ABOVE"
    },
    {
        "category": "HARM_CATEGORY_DANGEROUS_CONTENT",
        "threshold": "BLOCK_MEDIUM_AND_ABOVE"
    },
]

model = genai.GenerativeModel(model_name="gemini-1.5-pro-latest",
                              generation_config=generation_config,
                              safety_settings=safety_settings)

# 提示詞
prompt = "請在回答中加入一周的飲食菜單和一周的健身菜單，並包含每項活動所獲得和消耗的熱量，請使用繁體中文，並且請每次都使用固定格式回傳，但飲食和運動要有變化"


@app.route('/chat', methods=['POST'])
def chat():
    try:
        data = request.json
        user_input = data['user_input']
        height = data.get('height', 'N/A')
        weight = data.get('weight', 'N/A')
        dislikes = data.get('dislikes', 'N/A')
        goal = data.get('goal', 'N/A')

        additional_info = f"身高: {height} 公分, 體重: {weight} 公斤, 不喜歡吃的食物: {dislikes}, 目標: {goal}."
        complete_input = f"{user_input}\n\n{additional_info}\n\n{prompt}"

        # 每次請求都是獨立的一次生成。
        # 不共用 chat session，否則所有使用者會共享同一段對話歷史，
        # 別人的身高體重和目標會影響到你拿到的菜單。
        response = model.generate_content(complete_input)

        return jsonify({'response': response.text})
    except Exception as e:
        app.logger.error(f"Error in /chat endpoint: {str(e)}")
        return jsonify({'error': str(e)}), 500


if __name__ == '__main__':
    app.run(
        debug=os.environ.get("FLASK_DEBUG", "1") == "1",
        port=int(os.environ.get("PORT", 5000)),
    )
