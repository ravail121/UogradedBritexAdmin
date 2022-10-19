<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Portal</title>
    {!! Html::style('css/vendors/bootstrap.min.css') !!}
    {!! Html::style('css/fontawesome/css/all.min.css') !!}
    {!! Html::style('css/custom-style.css') !!}
    
    @stack('css')
    <script src="/js/vendors/sweetalert.min.js"></script>
    <title>{{ config('app.name') }}</title>
    
</head>
<body @yield('body-class')>
    
    @yield('loader-image')

    <div class="wrapper">

        @yield('side-bar')

        <div id="content" class="dashboardcontent">
            @yield('header')

            @yield('content')
        </div>
    </div>
    <script src="/js/vendors/prefixfree.min.js"></script>
    <script src="/js/vendors/jquery.min.js"></script>
    <script src="/js/vendors/popper.min.js"></script>
    <script src="/js/vendors/bootstrap.min.js"></script>
    {!! Html::script('theme/js/solid.js') !!}
    {!! Html::script('theme/js/fontawesome.js') !!}
    {!! Html::script('plugins/inputmask/jquery.inputmask.bundle.js') !!}

    <script src="/js/vendors/jquery.validate.min.js"></script>
    <script src="/js/vendors/additional-methods.min.js"></script>

    <script>
        $(function(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });
    window['_fs_debug'] = false;
    window['_fs_host'] = 'fullstory.com';
    window['_fs_org'] = 'P2WH6';
    window['_fs_namespace'] = 'FS';
    (function(m,n,e,t,l,o,g,y){
        if (e in m) {if(m.console && m.console.log) { m.console.log('FullStory namespace conflict. Please set window["_fs_namespace"].');} return;}
        g=m[e]=function(a,b,s){g.q?g.q.push([a,b,s]):g._api(a,b,s);};g.q=[];
        o=n.createElement(t);o.async=1;o.crossOrigin='anonymous';o.src='https://'+_fs_host+'/s/fs.js';
        y=n.getElementsByTagName(t)[0];y.parentNode.insertBefore(o,y);
        g.identify=function(i,v,s){g(l,{uid:i},s);if(v)g(l,v,s)};g.setUserVars=function(v,s){g(l,v,s)};g.event=function(i,v,s){g('event',{n:i,p:v},s)};
        g.shutdown=function(){g("rec",!1)};g.restart=function(){g("rec",!0)};
        g.log = function(a,b) { g("log", [a,b]) };
        g.consent=function(a){g("consent",!arguments.length||a)};
        g.identifyAccount=function(i,v){o='account';v=v||{};v.acctId=i;g(o,v)};
        g.clearUserCookie=function(){};
    })(window,document,window['_fs_namespace'],'script','user');

        function fallbackCopyTextToClipboard(text) {
            var textArea = document.createElement("textarea");
            textArea.value = text;

            // Avoid scrolling to bottom
            textArea.style.top = "0";
            textArea.style.left = "0";
            textArea.style.position = "fixed";

            document.body.appendChild(textArea);
            textArea.focus();
            textArea.select();

            try {
                var successful = document.execCommand('copy');
                var msg = successful ? 'successful' : 'unsuccessful';
                console.log('Fallback: Copying text command was ' + msg);
            } catch (err) {
                console.error('Fallback: Oops, unable to copy', err);
            }

            document.body.removeChild(textArea);
        }

        window.copyTextToClipboard = function (text) {
            if (!navigator.clipboard) {
                fallbackCopyTextToClipboard(text);
                return;
            }
            navigator.clipboard.writeText(text).then(function () {
                swal({
                    icon: 'success',
                    title: `Copied. Please paste.`,
                    timer: 400,
                    timerProgressBar: true,
                })
                console.log('Async: Copying to clipboard was successful!');
            }, function (err) {
                console.error('Async: Could not copy text: ', err);
            });
        }

    </script>

    @yield('validate-js')

    @stack('js')
</body>
</html>
