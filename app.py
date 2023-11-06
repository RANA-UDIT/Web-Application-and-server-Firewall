from flask import Flask, render_template, request, redirect
from flask_limiter import Limiter
from flask_limiter.util import get_remote_address

app = Flask(__name)

# Default Apache server port (can be customized)
apache_port = 80

# A simple variable to represent the firewall state (enabled or disabled)
firewall_enabled = True

# Set up rate limiting
limiter = Limiter(
    app,
    key_func=get_remote_address,
    default_limits=["5 per minute"],  # Adjust the limit to your desired rate
)

@app.route("/", methods=["GET"])
@limiter.request_filter
def index():
    return render_template("index.html")

@app.route("/configure", methods=["POST"])
@limiter.request_filter
def configure_firewall():
    global apache_port, firewall_enabled

    # Retrieve the custom Apache server port
    new_port = request.form.get("apachePort")
    if new_port:
        apache_port = int(new_port)

    # Toggle the firewall state
    if request.form.get("firewallToggle"):
        firewall_enabled = not firewall_enabled

    return redirect("/")

@app.route("/simulate-firewall", methods=["GET"])
def simulate_firewall():
    if firewall_enabled:
        return "Firewall is enabled. Access denied."
    else:
        return f"Accessing Apache server on port {apache_port}"

if __name__ == "__main__":
    app.run(debug=True)
