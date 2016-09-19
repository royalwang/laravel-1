<!DOCTYPE html>
<html lang="en">

@section('htmlheader')
    @include('layouts.partials.htmlheader')
@show

<body class="skin-blue sidebar-mini sidebar-collapse">
<div class="wrapper">

    @include('layouts.partials.mainheader')

    @include('layouts.partials.sidebar')


    <div class="content-wrapper">


        <section class="content clearfix">

            <div class="row">

                @include('layouts.partials.sub-sidebar')

                @include('layouts.partials.table')

            </div>

        </section>
    </div>

    @include('layouts.partials.controlsidebar')
        
    @include('layouts.partials.footer')

</div>

@section('scripts')
    @include('layouts.partials.scripts')
@show

</body>
</html>
