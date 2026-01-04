</main> <!-- Page Content End -->

<footer class="bg-dark text-white mt-auto">
    <div class="container py-4">
        <div class="row">
            <div class="col-md-4 mb-3">
                <h5>{{ config('app.name', 'Travel Management System') }}</h5>
                <p class="small mb-0">
                    Explore destinations and travel smarter with us.
                </p>
            </div>

            <div class="col-md-2 mb-3">
                <h6>Quick Links</h6>
                <ul class="list-unstyled">
                    <li><a href="{{ url('/') }}" class="text-white text-decoration-none">Home</a></li>
                    <li><a href="#" class="text-white text-decoration-none">Tours</a></li>
                    <li><a href="#" class="text-white text-decoration-none">Packages</a></li>
                </ul>
            </div>

            <div class="col-md-3 mb-3">
                <h6>Support</h6>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-white text-decoration-none">About</a></li>
                    <li><a href="#" class="text-white text-decoration-none">Privacy Policy</a></li>
                    <li><a href="#" class="text-white text-decoration-none">Terms</a></li>
                </ul>
            </div>

            <div class="col-md-3 mb-3">
                <h6>Contact</h6>
                <p class="small mb-1">📍 India</p>
                <p class="small mb-1">📞 +91 98765 43210</p>
                <p class="small mb-0">✉ support@travel.com</p>
            </div>
        </div>

        <hr class="border-secondary">

        <div class="text-center small">
            © {{ date('Y') }} {{ config('app.name', 'Travel Management System') }}. All Rights Reserved.
        </div>
    </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
