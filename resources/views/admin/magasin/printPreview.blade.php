<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Preview</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 20px;
        }
        h1 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        @media print {
            body * {
                visibility: hidden; /* Hide everything */
            }
            .print-preview, .print-preview * {
                visibility: visible; /* Show only the print preview content */
            }
            .print-preview {
                position: absolute; /* Positioning for print */
                left: 0;
                top: 0;
            }
        }
    </style>
</head>
<body>

<div class="print-preview">
    <h1>OPERATION EFFECTUEES</h1>
    <table>
        <thead>
            <tr>
                <th>ID Operation</th>
                <th>Materiel ID</th>
                <th>Type Operation</th>
                <th>Désignation</th>
                <th>Partenaire</th>
                <th>Date Operation</th>
                <th>Quantité</th>
            </tr>
        </thead>
        <tbody>
            @foreach($magasin as $item)
                <tr>
                    <td>{{ $item->id_operation }}</td>
                    <td>{{ $item->materiel_id }}</td>
                    <td>{{ $item->type_operation }}</td>
                    <td>{{ $item->designation }}</td>
                    <td>{{ $item->partenaire }}</td>
                    <td>{{ $item->date_operation }}</td>
                    <td>{{ $item->quantite }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<button onclick="window.print()" style="margin-top: 20px; display: block; margin-left: auto; margin-right: auto;">Print</button>

</body>
</html>