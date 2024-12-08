 // The workerSrc property shall be specified.
        pdfjsLib.GlobalWorkerOptions.workerSrc = "https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.4.120/pdf.worker.min.js";

        function zoomIn() {
            scale *= 1.1; // Increase scale by 10%
            renderPage(pageNum);
        }

        function zoomOut() {
            scale /= 1.1; // Decrease scale by 10%
            renderPage(pageNum);
        }


        var pdfDoc = null,
            pageNum = 1,
            pageRendering = false,
            pageNumPending = null,
            scale = 1,
            pagesToDisplay = 1, // Default to one page at a time
            canvas = document.getElementById('the-canvas'),
            ctx = canvas.getContext('2d');

        function displayOnePage() {
            pagesToDisplay = 1;
            renderPage(pageNum);
        }

        function displayTwoPages() {
            pagesToDisplay = 2;
            renderPage(pageNum);
        }

        function renderPage(num) {
    pageRendering = true;
    // Clear the pdf-container
    document.getElementById('pdf-container').innerHTML = '';

    // Using promise to fetch the page
    pdfDoc.getPage(num).then(function(page) {
        var viewport = page.getViewport({scale: scale});
        var canvas = document.createElement('canvas');
        makeCanvasUnclickable(canvas);
        var ctx = canvas.getContext('2d');
        canvas.height = viewport.height;
        canvas.width = viewport.width;
        document.getElementById('pdf-container').appendChild(canvas);

        // Render PDF page into canvas context
        var renderContext = {
            canvasContext: ctx,
            viewport: viewport
        };
        var renderTask = page.render(renderContext);

        // If two pages should be displayed and there is a next page, render it
        if (pagesToDisplay === 2 && num < pdfDoc.numPages) {
            var canvas2 = document.createElement('canvas');
            makeCanvasUnclickable(canvas2);
            var ctx2 = canvas2.getContext('2d');
            canvas2.height = viewport.height;
            canvas2.width = viewport.width;
            document.getElementById('pdf-container').appendChild(canvas2);

            pdfDoc.getPage(num + 1).then(function(page2) {
                var viewport2 = page2.getViewport({scale: scale});
                var renderContext2 = {
                    canvasContext: ctx2,
                    viewport: viewport2
                };
                page2.render(renderContext2);
            });
        }

        // Wait for rendering to finish
        renderTask.promise.then(function () {
            pageRendering = false;
            if (pageNumPending !== null) {
                // New page rendering is pending
                renderPage(pageNumPending);
                pageNumPending = null;
            }
        });
    });

    // Update page counters
    document.getElementById('page_num').textContent = num;
}


        function queueRenderPage(num) {
            if (pageRendering) {
                pageNumPending = num;
            } else {
                renderPage(num);
                document.getElementById('page-number').value = num;
            }
        }

        function prevPage() {
    if (pageNum <= 1) {
        return;
    }
    pageNum -= pagesToDisplay;
    if (pageNum < 1) {
        pageNum = 1;
    }
    queueRenderPage(pageNum);
}

function nextPage() {
    if (pageNum >= pdfDoc.numPages) {
        return;
    }
    pageNum += pagesToDisplay;
    if (pageNum > pdfDoc.numPages) {
        pageNum = pdfDoc.numPages;
    }
    queueRenderPage(pageNum);
}


        // Asynchronously downloads PDF through the proxy script
        pdfjsLib.getDocument(pdfUrl).promise.then(function(pdfDoc_) {
    pdfDoc = pdfDoc_;
    document.getElementById('page_count').textContent = pdfDoc.numPages;

    // Get the dimensions of the container box
    var containerWidth = document.querySelector('.pdf-area').offsetWidth;
    var containerHeight = document.querySelector('.pdf-area').offsetHeight;

    // Load the first page to get its dimensions
    pdfDoc.getPage(1).then(function(page) {
        var viewport = page.getViewport({ scale: 1 });
        var pageWidth = viewport.width;
        var pageHeight = viewport.height;

        // Calculate the initial scale to fit the page into the container
        var scaleX = containerWidth / pageWidth;
        var scaleY = containerHeight / pageHeight;
        var initialScale = Math.min(scaleX, scaleY);

        // Set the initial scale
        scale = initialScale;

        // Initial/first page rendering
        renderPage(pageNum);
    });
});


        // Function to make a canvas element unclickable
function makeCanvasUnclickable(canvas) {
    canvas.addEventListener('contextmenu', function (e) {
        e.preventDefault();
    });
    canvas.addEventListener('mousedown', function (e) {
        e.preventDefault();
    });
    canvas.addEventListener('mouseup', function (e) {
        e.preventDefault();
    });
    canvas.addEventListener('click', function (e) {
        e.preventDefault();
    });
    canvas.addEventListener('keydown', function (e) {
        // Prevent default behavior for printing and saving shortcuts
        if ((e.ctrlKey || e.metaKey) && (e.key === 'p' || e.key === 'P' || e.key === 's' || e.key === 'S')) {
            e.preventDefault();
        }
    });
}





// Function to navigate to a specific page
function goToPage(pageNum) {
    pageNum = Math.max(1, Math.min(pdfDoc.numPages, pageNum)); // Ensure pageNum is within valid range
    renderPage(pageNum);
}
document.getElementById('page-number').value = pageNum;

function resetInput() {
    var inputField = document.getElementById('page-number');
    var currentPage = document.getElementById('page_num').innerHTML; // Get the current page number from the page_num div
    inputField.value = currentPage; // Set the input field value to the current page number
}

// Function to navigate to a specific page number
function goToPageNumber() {
    var pageNumber = parseInt(document.getElementById('page-number').value);
    if (pageNumber && pageNumber > 0 && pageNumber <= pdfDoc.numPages) {
        pageNum = pageNumber; // Update the current page number
        document.getElementById('page_num').innerHTML = pageNum; // Update the page_num div
        goToPage(pageNumber);
        document.getElementById('page-number').blur();
    } else {
        alert("Please enter a valid page number.");
    }
}