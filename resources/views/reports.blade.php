<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <!-- Extra details for Live View on GitHub Pages -->
    <title>
        Slip
    </title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <style>
        * {
            font-family: "Figtree", "Helvetica Neue", Arial, sans-serif !important;
            -moz-osx-font-smoothing: grayscale;
            -webkit-font-smoothing: antialiased;
            font-size: 10px;
            line-height: 1em !important;
        }

        .h1,
        .h2,
        .h3,
        .h4,
        .h5,
        .h6,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            margin-top: 0;
            margin-bottom: .5rem;
            font-weight: 500;
            line-height: 1.2
        }

        h1,
        .h1 {
            font-size: 2.5rem;
        }

        h2,
        .h2 {
            font-size: 2rem;
        }

        h3,
        .h3 {
            font-size: 1.75rem;
        }

        h4,
        .h4 {
            font-size: 1.5rem;
        }

        h5,
        .h5 {
            font-size: 1.25rem;
        }

        h6,
        .h6 {
            font-size: 1rem;
        }

        .float-start {
            float: left !important;
        }

        .float-end {
            float: right !important;
        }

        .clearfix::after {
            display: block;
            clear: both;
            content: "";
        }

        .mt-1 {
            margin-top: .25rem !important
        }

        .mt-2 {
            margin-top: .5rem !important
        }

        .mt-3 {
            margin-top: 1rem !important
        }

        .mt-5 {
            margin-top: 1.5rem !important;
        }

        .p-1 {
            padding: .25rem !important
        }

        .p-2 {
            padding: .5rem !important
        }

        .p-3 {
            padding: 1rem !important
        }

        .small,
        small {
            font-size: .8em
        }

        table {
            caption-side: bottom;
            border-collapse: collapse;
            width: 100%;
        }

        .flex {
            display: flex;
        }

        .items-start {
            align-items: start;
        }

        .items-center {
            align-items: center;
        }

        .justify-between {
            justify-content: space-between;
        }

        .justify-end {
            justify-content: end;
        }

        .font-medium {
            font-weight: 500;
        }

        .font-semibold {
            font-weight: 600;
        }

        .font-bold {
            font-weight: 700;
        }

        .capitalize {
            text-transform: capitalize;
        }

        .uppercase {
            text-transform: uppercase;
        }

        .text-left {
            text-align: left !important
        }

        .text-right {
            text-align: right !important
        }

        .text-lg {
            font-size: 1.125rem;
            /* 18px */
        }

        .text-xl {
            font-size: 1.25rem;
            /* 20px */
        }

        .text-2xl {
            font-size: 1.5rem;
            /* 24px */
        }

        .grid {
            display: grid;
        }

        .grid-cols-4 {
            grid-template-columns: repeat(4, minmax(0, 1fr));
        }

        .gap-1>* {
            margin: 0.25rem;
        }


        .gap-3>* {
            --tw-space-x-reverse: 0;
            margin-right: calc(0.75rem * var(--tw-space-x-reverse));
            margin-left: calc(0.75rem * (1 - var(--tw-space-x-reverse)));
        }

        .gap-5>* {
            --tw-space-x-reverse: 0;
            margin-right: calc(1.25rem * var(--tw-space-x-reverse));
            margin-left: calc(1.25rem * (1 - var(--tw-space-x-reverse)));
        }

        .col-span-2 {
            grid-column: span 2;
        }

        .col-span-3 {
            grid-column: span 3;
        }

        .border {
            border-width: 1px;
            border-style: solid;
        }

        .border-1 {
            border-width: 1px;
            border-style: solid;
        }

        .border-black {
            border-color: #000 !important;
        }

        .border-b {
            border-bottom-width: 1px;
            border-bottom-style: solid;
        }

        .bg-gray-100 {
            background-color: #E5E7EB;
        }


        /* Custom CSS to create table-striped effect */
        .table-striped tbody tr:nth-child(odd) {
            background-color: #fff;
            /* Background color for odd rows */
        }

        .table-striped tbody tr:nth-child(even) {
            background-color: rgb(243 244 246);
            /* Background color for even rows */
        }

        /* Additional styles for table */
        .table-striped {
            width: 100%;
            border-collapse: collapse;
        }

        .px-1 {
            padding-left: .25rem !important;
            padding-right: .25rem !important;
        }

        .py-2 {
            padding-top: .5rem !important;
            padding-bottom: .5rem !important;
        }
    </style>

</head>

<body>

    <div class="float-start">
        <span class="font-bold uppercase h3">report</span>
        <br>
        <!-- company's details -->
        <span class="uppercase font-bold h5">{{ config('app.name')}}
        </span>

        <p class="font-bold uppercase h6 mt-1">
            from: {{ $from }}
            <br>
            to: {{ $to}}
        </p>
    </div>

    <div class="float-end">
        <img src="" class="mt-2" height="70">
    </div>

    <div class="clearfix"></div>

    <div class="mt-3">
        <table class="table-striped">
            <thead class="capitalize bg-gray-100 font-medium">
                <tr>
                    <th scope="col" class="text-sm text-gray-900 px-1 py-2 text-left">
                        recorded at
                    </th>
                    <th scope="col" class="text-sm text-gray-900 px-1 py-2 text-left">
                        name
                    </th>
                    <th scope="col" class="text-sm text-gray-900 px-1 py-2 text-left">
                        phone
                    </th>
                    <th scope="col" class="text-sm text-gray-900 px-1 py-2 text-left">
                        location
                    </th>
                    <th scope="col" class="text-sm text-gray-900 px-1 py-2 text-left">
                        Age Group
                    </th>
                    <th scope="col" class="text-sm text-gray-900 px-1 py-2 text-left">
                        product category
                    </th>
                    <th scope="col" class="text-sm text-gray-900 px-1 py-2 text-left">
                        branch
                    </th>
                    <th scope="col" class="text-sm text-gray-900 px-1 py-2 text-left">
                        remarks
                    </th>
                    <th scope="col" class="text-sm text-gray-900 px-1 py-2 text-left">
                        recorded by
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $client)
                <tr>
                    <td class="px-1 py-2 text-left">{{ $client->updated_at->format('d/m/Y H:i') }}</td>
                    <td class="px-1 py-2 text-left">{{ $client->name }}</td>
                    <td class="px-1 py-2 text-left">{{ $client->phone }}</td>
                    <td class="px-1 py-2 text-left">{{ $client->location }}</td>
                    <td class="px-1 py-2 text-left">{{ $client->age_group->title }}</td>
                    <td class="px-1 py-2 text-left">{{ $client->product_category->title }}</td>
                    <td class="px-1 py-2 text-left">{{ $client->branch->title }}</td>
                    <td class="px-1 py-2 text-left">{{ $client->remarks }}</td>
                    <td class="px-1 py-2 text-left">{{ $client->user->name }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center">No data available in table</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</body>

</html>