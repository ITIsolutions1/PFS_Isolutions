<!DOCTYPE html>
<html lang="en">
<head>
    <title>Certification of Completion</title>
    <style>
        body {
            font-family: "Times New Roman", Times, serif;
            margin: 0;
            padding: 0;
            background-image: url('{{ public_path('images/bast.png') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            height: 90vh; 
            width: 100%;
        }

        @page {
            size: A4;
            margin: 0;
        }

        .container {
            margin-top: 70px;
            padding: 60px;
        }

        .judul {
            text-align: center;
            margin-top: 5px;
        }
        .judul h2 {
            margin-bottom: 0;
        }
        .judul p {
            margin-top: 0;
            font-size: 15px;
        }

        .letak td {
            font-size: 15px;
            vertical-align: top;
            padding: 3px 0;
        }

        p, li {
            font-size: 15px;
        }
        li {
            margin-top: -5px;
        }

        /* Signature table */
        table.ttd {
            width: 100%;
            border-collapse: collapse;
            text-align: center;
            table-layout: fixed;
            margin-top: 15px;
        }
        table.ttd td {
            border: 1px solid black;
            padding: 5px 10px;
            font-size: 15px;
        }
        table.ttd tr:nth-child(2) td {
            height: 100px;
        }
        table.ttd tr:nth-child(3) td {
            height: 15px;
        }

        /* Checkbox styling */
        .checkbox-group {
            margin-top: 10px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .checkbox-item {
            display: flex;
            align-items: flex-start;
            gap: 8px;
            font-size: 14px;
            line-height: 1.4;
        }
        .checkbox-item input[type="checkbox"] {
            margin-top: 3px;
            width: 16px;
            height: 16px;
        }
    </style>
</head>

<body>

<div class="container">

    <!-- Judul -->
    <div class="judul">
        <h2>CERTIFICATION OF COMPLETIONS</h2>
        <p>Berita Acara Serah Terima Pekerjaan</p>
    </div>

    <!-- Opening paragraph -->
    <p>
        This certificate is to confirm and certify that the below scope of work has been witnessed 
        and completed in accordance with Client specifications and governing codes and standards, 
        unless agreed and stated otherwise.
    </p>

    <!-- Table Detail -->
    <table class="letak">
        <tr>
            <td>Project No</td>
            <td>:</td>
            <td><div style="width: 430px;">{{ $experiences->project_no }}</div></td>
        </tr>
        <tr>
            <td>Project Name</td>
            <td>:</td>
            <td><div style="width: 430px;">{{ $experiences->project_name }}</div></td>
        </tr>
        <tr>
            <td>Client Name</td>
            <td>:</td>
            <td><div style="width: 430px;">{{ $experiences->client_name }}</div></td>
        </tr>
        <tr>
            <td>Date Start</td>
            <td>:</td>
            <td><div style="width: 430px;">{{ date('d F Y', strtotime($experiences->date_project_start)) }}</div></td>
        </tr>
        <tr>
            <td>Date End</td>
            <td>:</td>
            <td><div style="width: 430px;">{{ date('d F Y', strtotime($experiences->date_project_end)) }}</div></td>
        </tr>
        <tr>
            <td>Area/Locations</td>
            <td>:</td>
            <td><div style="width: 430px;">{{ $experiences->locations }}</div></td>
        </tr>
        <tr>
            <td>KBLI Number</td>
            <td>:</td>
            <td><div style="width: 430px;">{{ $experiences->kbli_number }}</div></td>
        </tr>
    </table>

    <!-- Description -->
    <div class="description">
        <p><b>Description of Work/Project:</b></p>
        <ul>
            <li>{{ $experiences->scope_of_work }}</li>
        </ul>

        <p><b>Conditions of Handover:</b></p>
        <ul>
            <li>
                All necessary documents and materials related to the work/project have been
                provided as per contract. Any issues or pending items from the previous phase
                have been discussed and acknowledged by the receiving party.
            </li>
        </ul>
    </div>

        <div class="checkbox-group">
        <label class="checkbox-item">
            <input type="checkbox" name="agree_logo">
            <span>Agreement to allow the company logo to be displayed on documents and materials related to this project.</span>
        </label>

        <label class="checkbox-item">
            <input type="checkbox" name="agree_announcement">
            <span>Agreement to include information regarding this project in the company's official announcements or publications.</span>
        </label>

        <label class="checkbox-item">
            <input type="checkbox" name="agree_profile">
            <span>Agreement to display the company profile in promotional or publication materials related to this project.</span>
        </label>
    </div>


    <!-- Closing paragraph -->
    <p>
        By signing this document, both parties confirm that the job handover has been carried out 
        to mutual satisfaction and that the receiving party is now responsible for the continued 
        progress or completion of the work.
    </p>

    <!-- Signature Table -->
    <table class="ttd">
        <tr>
            <td>PT Intra Multi Global Solusi</td>
            <td>Client</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td>Indah Nursanti</td>
            <td>{{ $experiences->client_name }}</td>
        </tr>
    </table>

    <!-- Checkbox Agreement -->
    <!-- <div class="checkbox-group">
        <label class="checkbox-item">
            <input type="checkbox" name="agree_logo">
            <span>Agreement to allow the company logo to be displayed on documents and materials related to this project.</span>
        </label>

        <label class="checkbox-item">
            <input type="checkbox" name="agree_announcement">
            <span>Agreement to include information regarding this project in the company's official announcements or publications.</span>
        </label>

        <label class="checkbox-item">
            <input type="checkbox" name="agree_profile">
            <span>Agreement to display the company profile in promotional or publication materials related to this project.</span>
        </label>
    </div> -->

</div>

</body>
</html>
