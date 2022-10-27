<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <link rel="stylesheet"  href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">


        <style>
            /* * {
                    margin: 0;
                    padding: 0;
                    box-sizing: border-box;
                    font-family: 'Fira sans', sans-serif;
                } */
            body {
                background: #f9f9fb;
                padding: 20px;
            }
            .content_data{
                width: 70%;
                margin: auto;
            }
            .form{
                width: 60%;
                padding: 20px
            }
            input{
                padding: 9px 15px;
    border: 1px solid #e0e0e0;
    border-radius: 4px;
    width: 40%;
    margin-left: 5%;
    margin-top: 5px;
    margin-bottom: 5px;
            }

        </style>
    </head>
    <body >
        <div class="content_data">

            <div class="form">
                <form action="{{ url('charge') }}" method="post">
                    <input type="text" name="amount" required>
                    {{ csrf_field() }}
                    <input  type="submit" name="submit" value="pay now">
                </form>
            </div>

            <table id="table_id" class="dataTable">
                <thead>
                    <tr>
                        <th>payment_id</th>
                        <th>amount </th>
                        <th>currency</th>
                        <th>status</th>
                        <th>created at</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>


        </div>
        <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
        <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

        <script type="text/javascript">
            $(document).ready(function(){
                $('.dataTable').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{route('getDataTable')}}",
                    columns: [
                        { data: 'payment_id' },
                        { data: 'amount' },
                        { data: 'currency' },
                        { data: 'status' },
                        { data: 'created_at' },
                    ]
                });
            });
        </script>
    </body>

</html>
