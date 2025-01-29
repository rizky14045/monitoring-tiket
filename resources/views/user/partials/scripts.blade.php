<!-- Vendor -->
<script src="{{asset('assets/libs/jquery/jquery.min.js')}}"></script>
<script src="{{asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/libs/simplebar/simplebar.min.js')}}"></script>
<script src="{{asset('assets/libs/node-waves/waves.min.js')}}"></script>
<script src="{{asset('assets/libs/waypoints/lib/jquery.waypoints.min.js')}}"></script>
<script src="{{asset('assets/libs/jquery.counterup/jquery.counterup.min.js')}}"></script>
<script src="{{asset('assets/libs/feather-icons/feather.min.js')}}"></script>

<!-- Apexcharts JS -->
<script src="{{asset('assets/libs/apexcharts/apexcharts.min.js')}}"></script>

<!-- for basic area chart -->
<script src="https://apexcharts.com/samples/assets/stock-prices.js"></script>

<!-- Widgets Init Js -->
<script src="{{asset('assets/js/pages/analytics-dashboard.init.js')}}"></script>

<!-- App js-->
<script src="{{asset('assets/js/app.js')}}"></script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script type="text/javascript" src="{{ asset('assets/js/xlsx.full.min.js') }}"></script>
<script>
    function ExportToExcel(type, fn, dl) {
        var elt = document.getElementById('table');
        var wb = XLSX.utils.table_to_book(elt, {
            sheet: "sheet1"
        });
        return dl ?
            XLSX.write(wb, {
                bookType: type,
                bookSST: true,
                type: 'base64'
            }) :
            XLSX.writeFile(wb, fn || ('Document.' + (type || 'xlsx')));
    }
</script>