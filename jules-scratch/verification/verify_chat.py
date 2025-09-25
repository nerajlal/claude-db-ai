from playwright.sync_api import sync_playwright, expect

def run(playwright):
    browser = playwright.chromium.launch(headless=True)
    context = browser.new_context()
    page = context.new_page()

    try:
        # 1. Navigate to the application
        page.goto("http://127.0.0.1:8000/", timeout=60000)

        # Wait for the login page to load
        expect(page.locator('input[name="email"]')).to_be_visible(timeout=30000)

        # 2. Log in
        page.locator('input[name="email"]').fill("test@example.com")
        page.locator('input[name="password"]').fill("password")
        page.get_by_role("button", name="Login").click()

        # Wait for the home page to load after login
        expect(page.locator("#messageInput")).to_be_visible(timeout=30000)

        # 3. Send a message
        message_input = page.locator("#messageInput")
        message_input.fill("Hello, this is a test.")
        page.get_by_role("button").last.click()

        # 4. Wait for the response and take a screenshot
        # Wait for the user message to appear
        expect(page.locator("p").get_by_text("Hello, this is a test.")).to_be_visible(timeout=10000)

        # Wait for the assistant's response to appear.
        # We don't know the exact response, so we'll wait for the assistant message container.
        assistant_message_locator = page.locator(".dark\\:bg-gray-800 .text-lg")
        expect(assistant_message_locator).to_be_visible(timeout=30000)

        page.screenshot(path="jules-scratch/verification/verification.png")

    except Exception as e:
        print(f"An error occurred: {e}")
        page.screenshot(path="jules-scratch/verification/error.png")

    finally:
        browser.close()

with sync_playwright() as playwright:
    run(playwright)