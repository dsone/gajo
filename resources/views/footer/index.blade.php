<footer class="footer animated delay-slow faster" role="contentinfo">
	<div class="container">
        <span class="no-spacing">
            <a href="{{ route('privacy') }}" target="_self" rel="nofollow">Privacy</a>
        </span>
        <span class="no-spacing">
            <a href="#" class="footer_link_c">Enable JS</a>
            <script>
                (function() {
                    link = document.querySelector('.footer_link_c');
                    link.innerHTML = "{{ \Config::get('app.contact_mail') }}";
                    link.href = 'mailto:' + link.innerHTML;
                })()
            </script>
        </span>
	</div>
</footer>