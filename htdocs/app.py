from flask import Flask, render_template, request, redirect

'''app = Flask(__name)'''

@app.route('/')
def index():
    return render_template('index.php')

@app.route('/check', methods=['POST'])
def check_sql_injection():
    # Your SQL injection detection logic here
    # ...

    return "Query Successful"

@app.route('/block')
def block():
    return render_template('block.html')

if __name__ == '__main__':
    app.run()
