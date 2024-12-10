<?php $this->view('librarian/includes/sidenav'); ?>

<?php if (message()): ?>

    <div class="<?= isset($_SESSION['message_class']) ? $_SESSION['message_class'] : 'alert'; ?>">
        <?= message('', true) ?>
    </div>
    <?php unset($_SESSION['message_class']); ?>

<?php endif; ?>
<memberProfile>


    <main id="contentToCapture">

        <div class="insights">
            <div class="sales box-1">

                <span><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
                        <path d="M560-564v-68q33-14 67.5-21t72.5-7q26 0 51 4t49 10v64q-24-9-48.5-13.5T700-600q-38 0-73 9.5T560-564Zm0 220v-68q33-14 67.5-21t72.5-7q26 0 51 4t49 10v64q-24-9-48.5-13.5T700-380q-38 0-73 9t-67 27Zm0-110v-68q33-14 67.5-21t72.5-7q26 0 51 4t49 10v64q-24-9-48.5-13.5T700-490q-38 0-73 9.5T560-454ZM260-320q47 0 91.5 10.5T440-278v-394q-41-24-87-36t-93-12q-36 0-71.5 7T120-692v396q35-12 69.5-18t70.5-6Zm260 42q44-21 88.5-31.5T700-320q36 0 70.5 6t69.5 18v-396q-33-14-68.5-21t-71.5-7q-47 0-93 12t-87 36v394Zm-40 118q-48-38-104-59t-116-21q-42 0-82.5 11T100-198q-21 11-40.5-1T40-234v-482q0-11 5.5-21T62-752q46-24 96-36t102-12q58 0 113.5 15T480-740q51-30 106.5-45T700-800q52 0 102 12t96 36q11 5 16.5 15t5.5 21v482q0 23-19.5 35t-40.5 1q-37-20-77.5-31T700-240q-60 0-116 21t-104 59ZM280-494Z" />
                    </svg></span>
                <div class="middle">
                    <div class="left">
                        <h3>Total E - Books</h3>
                        <h1>$25,023</h1>
                    </div>

                </div>
                <small>Last 24 hours</small>
            </div>
            <div class="sales box-2">

                <span><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
                        <path d="M480-60q-72-68-165-104t-195-36v-440q101 0 194 36.5T480-498q73-69 166-105.5T840-640v440q-103 0-195.5 36T480-60Zm0-104q63-47 134-75t146-37v-276q-73 13-143.5 52.5T480-394q-66-66-136.5-105.5T200-552v276q75 9 146 37t134 75Zm0-436q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47Zm0-80q33 0 56.5-23.5T560-760q0-33-23.5-56.5T480-840q-33 0-56.5 23.5T400-760q0 33 23.5 56.5T480-680Zm0-80Zm0 366Z" />
                    </svg></span>
                <div class="middle">
                    <div class="left">
                        <h3>Total Borrowings</h3>
                        <h1>$25,023</h1>
                    </div>

                </div>
                <small>Last 24 hours</small>
            </div>
            <div class="sales box-3">

                <span style="height: 20px;"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
                        <path d="M40-160v-112q0-34 17.5-62.5T104-378q62-31 126-46.5T360-440q66 0 130 15.5T616-378q29 15 46.5 43.5T680-272v112H40Zm720 0v-120q0-44-24.5-84.5T666-434q51 6 96 20.5t84 35.5q36 20 55 44.5t19 53.5v120H760ZM360-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47Zm400-160q0 66-47 113t-113 47q-11 0-28-2.5t-28-5.5q27-32 41.5-71t14.5-81q0-42-14.5-81T544-792q14-5 28-6.5t28-1.5q66 0 113 47t47 113ZM120-240h480v-32q0-11-5.5-20T580-306q-54-27-109-40.5T360-360q-56 0-111 13.5T140-306q-9 5-14.5 14t-5.5 20v32Zm240-320q33 0 56.5-23.5T440-640q0-33-23.5-56.5T360-720q-33 0-56.5 23.5T280-640q0 33 23.5 56.5T360-560Zm0 320Zm0-400Z" />
                    </svg></span>
                <div class="middle">
                    <div class="left">
                        <h3>Total Registered Users</h3>
                        <h1>$25,023</h1>
                    </div>

                </div>
                <small>Last 24 hours</small>
            </div>
            <div class="sales box-5">

                <span style="height: 20px;"><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed">
                        <path d="M560-440q-50 0-85-35t-35-85q0-50 35-85t85-35q50 0 85 35t35 85q0 50-35 85t-85 35ZM280-320q-33 0-56.5-23.5T200-400v-320q0-33 23.5-56.5T280-800h560q33 0 56.5 23.5T920-720v320q0 33-23.5 56.5T840-320H280Zm80-80h400q0-33 23.5-56.5T840-480v-160q-33 0-56.5-23.5T760-720H360q0 33-23.5 56.5T280-640v160q33 0 56.5 23.5T360-400Zm440 240H120q-33 0-56.5-23.5T40-240v-440h80v440h680v80ZM280-400v-320 320Z" />
                    </svg></span>
                <div class="middle">
                    <div class="left">
                        <h3>Total profit</h3>
                        <h1>$25,02</h1>
                    </div>

                </div>
                <small>Last 24 hours</small>
            </div>
            <div class="sales box-6" style="height:5px">



                <h4 id="generateReport" style="cursor:pointer">Generate Report <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#5179ef">
                        <path d="m321-80-71-71 329-329-329-329 71-71 400 400L321-80Z" />
                    </svg></h4>
            </div>
            <div class="chart box-4">
                <canvas id="profitabilityChart" width="800" height="400"></canvas>

            </div>


        </div>




    </main>
    <div id="pdfTemplate" style="display:none;">
        <div style="font-family: Arial, sans-serif; padding: 20px;">
            <h1 style="text-align: center;">Report</h1>
            <p>Date: <span id="datePlaceholder"></span></p>
            <p>Business: <span id="businessNamePlaceholder"></span></p>
            <table cellpadding="10" cellspacing="0" style="width: 100%; margin-top: 20px;">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody id="itemsTable">
                    <!-- Dynamic rows will be added here -->
                </tbody>
            </table>
        </div>
    </div>



</memberProfile>
<script src="<?= ROOT ?>/assets/js/dashboard.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js" integrity="sha512-BNaRQnYJYiPSqHHDb58B0yaPfCu+Wgds8Gp/gU33kqBtgNS4tSPHuGibyoeqMV/TJlSKda6FXzoEyYGjTe+vXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


<script>
    document.getElementById('generateReport').addEventListener('click', function() {
        const {
            jsPDF
        } = window.jspdf;

        // Capture the screenshot of the content
        html2canvas(document.getElementById('contentToCapture'), {
            scale: 2 // Set the scale to control resolution (you can adjust this)
        }).then(function(canvas) {
            // Convert the canvas to image data
            const imgData = canvas.toDataURL('image/png');

            // Create a new PDF
            const pdf = new jsPDF();

            // Get the dimensions of the canvas
            const width = canvas.width;
            const height = canvas.height;

            // Calculate scale factor for fitting content into a single page
            const pdfWidth = 210; // A4 width in mm
            const pdfHeight = 297; // A4 height in mm
            const scaleFactor = Math.min(pdfWidth / width, pdfHeight / height);

            // Add the image to the PDF (apply the scale factor for fitting)
            pdf.addImage(imgData, 'PNG', 0, 0, width * scaleFactor, height * scaleFactor);

            // Save the PDF
            pdf.save('report.pdf');
        });
    });
</script>
<?php $this->view('member/includes/footer'); ?>