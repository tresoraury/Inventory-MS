<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Preview - Produits du Stocks</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 20px;
        }
        .card_image {
            width: 100px;
            height: 100px;
            position: absolute;
            right: 20px;
            top: 20px;
        }
        h1 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        td {
            border: 1px solid #ddd;
            padding: 15px;
            text-align: left;
        }
        th {
            background-color: #4CAF50;
            color: white;
            font-size: 1em;
        }
        @media print {
            .btn-print {
                display: none; /* Hide print button when printing */
            }
        }
    </style>
</head>
<body>



<h1>Produits du Stocks</h1>

<table>
    <thead>
        <tr>
            <th>No_code</th>
            <th>Désignation</th>
            <th>Unité d'Emploi</th>
            <th>Rangement</th>
            <th>Quantité</th>
        </tr>
    </thead>
    <tbody>
        @foreach($materiaux as $data)
            <tr>
                <td>{{ $data->No_code }}</td>
                <td>{{ $data->designation }}</td>
                <td>{{ $data->unite_emploie }}</td>
                <td>{{ $data->rangement }}</td>
                <td>{{ $data->quantite }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

<button onclick="window.print()" style="margin-top: 20px; display: block; margin-left: auto; margin-right: auto;">Print</button>

</body>
</html>