import qrcode

# Define the link you want to encode
link = 'https://in2eco.com'

# Create a QR code object
qr = qrcode.QRCode(
    version=1,  # Controls the size of the QR Code
    error_correction=qrcode.constants.ERROR_CORRECT_L,  # Controls the error correction used
    box_size=20,  # Controls how many pixels each “box” of the QR code is
    border=4,  # Controls how many boxes thick the border should be
)

# Add the link to the QR code object
qr.add_data(link)
qr.make(fit=True)

# Create an image of the QR code
img = qr.make_image(fill='black', back_color='white')

# Save the image to a file
img.save('qrcode.png')

print("QR code generated and saved as 'qrcode.png'")
