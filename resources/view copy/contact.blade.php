<x-layout>
    <section class="min-h-screen py-12">
        <div class="w-full mx-auto">
            <!-- Hero Section -->
            <div class="bg-gray-100 text-gray-900 py-12 px-6 flex flex-col md:flex-row items-center justify-between shadow-lg rounded-lg">
                <div class="max-w-lg">
                    <h1 class="text-4xl font-bold mb-3">Get in Touch</h1>
                    <p class="text-lg">We'd love to hear from you. Here’s how you can reach us.</p>
                </div>
                <div class="hidden md:block">
                    <img src="https://img.freepik.com/free-vector/customer-support-illustration_23-2148899266.jpg" 
                         alt="Customer Support" class="rounded-lg w-60 md:w-72 h-auto">
                </div>
            </div>

            <!-- Social Media Links -->
            <div class="bg-white shadow-lg rounded-lg p-6 mt-6 text-center">
                <h2 class="text-xl font-semibold mb-4">Follow Us</h2>
                <div class="flex justify-center space-x-6">
                    <a href="https://www.facebook.com/yourprofile" target="_blank" class="text-blue-600 text-2xl hover:text-blue-800">
                        <i class="fab fa-facebook"></i>
                    </a>
                    <a href="https://www.instagram.com/yourprofile" target="_blank" class="text-pink-500 text-2xl hover:text-pink-700">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="https://www.linkedin.com/in/yourprofile" target="_blank" class="text-blue-700 text-2xl hover:text-blue-900">
                        <i class="fab fa-linkedin"></i>
                    </a>
                </div>
            </div>

            <!-- Office Location -->
            <div class="bg-white py-12 px-6 shadow-lg rounded-lg mt-6">
                <h2 class="text-center text-2xl font-bold mb-6">Our Global Office</h2>
                <div class="flex flex-col md:flex-row items-center justify-center gap-6">
                    <!-- Map -->
                    <div class="w-full md:w-1/2">
                        <div class="shadow-lg rounded-lg overflow-hidden">
                            <iframe class="w-full h-64"
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3151.83543450961!2d-122.41941518468191!3d37.77492977975937!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8085808c8b20b8d7%3A0x7b8a68d4b7c0f6cf!2sGoogle!5e0!3m2!1sen!2us!4v1616704317766!5m2!1sen!2us" 
                                allowfullscreen="" loading="lazy">
                            </iframe>
                        </div>
                    </div>

                    <!-- Address Details -->
                    <div class="w-full md:w-1/2 rounded-lg p-6">
                        <h3 class="text-xl font-semibold">Global Headquarters</h3>
                        <p class="text-gray-600 mt-2">123 Organic Street, Green City, Earth - 56789</p>
                        <p class="text-gray-600 mt-1"><strong>Mobile:</strong> +1 888 482 7768</p>
                        <p class="text-gray-600 mt-1"><strong>Fax:</strong> +1 617 812 5820</p>
                        <a href="#" class="text-blue-600 font-semibold hover:underline mt-2 block">Visit our Newsroom for contact info</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layout>
