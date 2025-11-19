<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Inspection Report - {{ $product->getTitle() }}</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { text-align: center; margin-bottom: 30px; }
        .section { margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 8px; border: 1px solid #ddd; text-align: left; }
        th { background-color: #f3f4f6; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Inspection Report</h1>
        <p>Premium Bikes Marketplace</p>
    </div>

    <div class="section">
        <h2>Product Information</h2>
        <table>
            <tr>
                <th>Title</th>
                <td>{{ $product->getTitle() }}</td>
            </tr>
            <tr>
                <th>Brand</th>
                <td>{{ $product->getBrand() ?: 'N/A' }}</td>
            </tr>
            <tr>
                <th>Model</th>
                <td>{{ $product->getModel() ?: 'N/A' }}</td>
            </tr>
            <tr>
                <th>Year</th>
                <td>{{ $product->getYear() ?: 'N/A' }}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <h2>Inspection Results</h2>
        <table>
            <tr>
                <th>Component</th>
                <th>Grade</th>
                <th>Notes</th>
            </tr>
            @if($inspection->getFrameCondition())
                <tr>
                    <td>Frame</td>
                    <td>{{ $inspection->getFrameCondition()->getDisplayName() }}</td>
                    <td>{{ $inspection->getFrameCondition()->getNotes() ?: 'N/A' }}</td>
                </tr>
            @endif
            @if($inspection->getBrakeCondition())
                <tr>
                    <td>Brakes</td>
                    <td>{{ $inspection->getBrakeCondition()->getDisplayName() }}</td>
                    <td>{{ $inspection->getBrakeCondition()->getNotes() ?: 'N/A' }}</td>
                </tr>
            @endif
            @if($inspection->getGroupsetCondition())
                <tr>
                    <td>Groupset</td>
                    <td>{{ $inspection->getGroupsetCondition()->getDisplayName() }}</td>
                    <td>{{ $inspection->getGroupsetCondition()->getNotes() ?: 'N/A' }}</td>
                </tr>
            @endif
            @if($inspection->getWheelsCondition())
                <tr>
                    <td>Wheels</td>
                    <td>{{ $inspection->getWheelsCondition()->getDisplayName() }}</td>
                    <td>{{ $inspection->getWheelsCondition()->getNotes() ?: 'N/A' }}</td>
                </tr>
            @endif
            @if($inspection->getOverallGrade())
                <tr>
                    <td><strong>Overall Grade</strong></td>
                    <td><strong>{{ $inspection->getOverallGrade() }}</strong></td>
                    <td></td>
                </tr>
            @endif
        </table>
    </div>

    @if($inspection->getNotes())
        <div class="section">
            <h2>Additional Notes</h2>
            <p>{{ $inspection->getNotes() }}</p>
        </div>
    @endif

    <div class="section">
        <p><strong>Inspection Date:</strong> {{ $inspection->getCompletedAt()?->format('Y-m-d H:i:s') ?: 'N/A' }}</p>
        <p><strong>Workshop ID:</strong> {{ $inspection->getWorkshopId() }}</p>
    </div>
</body>
</html>

