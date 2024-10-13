import './bootstrap';

// crawData
// product
let productItem = document.querySelectorAll('.product-item');

let key = 0;
for (each of productItem) {
    const colors = each.querySelectorAll('.swatch-option.color');
    let i = 0;
    for (color of colors) {
        color.click();
        await delay(500);
        const image = each.querySelector('.product-image-photo');
        const label = each.querySelector('.product-item-name').getAttribute('aria-label');
        downloadImage(image.src, `${label}_${key}-${i}`);
        i++;
    }
    key++;
}

function downloadImage(imageUrl, filename) {
    // Create an invisible link element
    const link = document.createElement('a');

    // Set the URL of the image
    link.href = imageUrl;

    // Set the filename for the downloaded image
    link.download = filename;

    // Append the link to the body (it won't be visible)
    document.body.appendChild(link);

    // Trigger a click event on the link to start the download
    link.click();

    // Remove the link from the document
    document.body.removeChild(link);
}

function delay(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}