@extends('layouts.app')

@section('content')
<!-- Hero Section - Updated with Image Background -->
<section class="hero-section position-relative vh-100 d-flex align-items-center">
    <div class="hero-image-overlay position-absolute top-0 start-0 w-100 h-100 bg-dark opacity-50"></div>
    <div class="hero-image position-absolute top-0 start-0 w-100 h-100">
        <img src="images/hero.jpg" class="object-fit-cover w-100 h-100" alt="Luxury Hotel">
    </div>
    <div class="container position-relative z-index-1 text-center text-white">
        <h1 class="display-3 fw-bold mb-4 animate__animated animate__fadeInDown">Luxury Redefined</h1>
        <p class="lead fs-4 mb-5 animate__animated animate__fadeIn animate__delay-1s">Where timeless elegance meets modern comfort</p>
        <div class="d-flex justify-content-center gap-3">
            <a href="{{ route('register') }}" class="btn btn-primary btn-lg px-4 py-3 rounded-pill animate__animated animate__fadeInUp animate__delay-1s">Book Now</a>
            <a href="#explore" class="btn btn-outline-light btn-lg px-4 py-3 rounded-pill animate__animated animate__fadeInUp animate__delay-1s">Explore</a>
        </div>
    </div>
    <div class="scroll-indicator position-absolute bottom-0 start-50 translate-middle-x mb-4">
        <div class="chevron"></div>
        <div class="chevron"></div>
        <div class="chevron"></div>
    </div>
</section>

<!-- Features Section - Enhanced -->
<section id="explore" class="py-5 bg-light">
    <div class="container py-5">
        <div class="text-center mb-5">
            <span class="text-warning fw-bold mb-2 d-block">EXPERIENCE LUXURY</span>
            <h2 class="display-5 fw-bold position-relative d-inline-block">Why Choose Us
                <span class="position-absolute bottom-0 start-50 translate-middle-x bg-warning" style="height: 4px; width: 80px;"></span>
            </h2>
            <p class="lead text-muted mt-3 mx-auto" style="max-width: 700px;">Discover the perfect blend of luxury, comfort, and exceptional service that sets us apart</p>
        </div>

        <div class="row g-4">
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm hover-lift">
                    <div class="card-body text-center p-4">
                        <div class="icon-wrapper bg-warning bg-opacity-10 text-warning rounded-circle mx-auto mb-4" style="width: 80px; height: 80px; line-height: 80px;">
                            <i class="fas fa-wifi fa-2x"></i>
                        </div>
                        <h3 class="h4 mb-3">Free High-Speed WiFi</h3>
                        <p class="text-muted mb-0">Stay connected with our complimentary high-speed internet access throughout the property.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm hover-lift">
                    <div class="card-body text-center p-4">
                        <div class="icon-wrapper bg-warning bg-opacity-10 text-warning rounded-circle mx-auto mb-4" style="width: 80px; height: 80px; line-height: 80px;">
                            <i class="fas fa-concierge-bell fa-2x"></i>
                        </div>
                        <h3 class="h4 mb-3">24/7 Concierge</h3>
                        <p class="text-muted mb-0">Our dedicated concierge team is available around the clock to assist with all your needs.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm hover-lift">
                    <div class="card-body text-center p-4">
                        <div class="icon-wrapper bg-warning bg-opacity-10 text-warning rounded-circle mx-auto mb-4" style="width: 80px; height: 80px; line-height: 80px;">
                            <i class="fas fa-spa fa-2x"></i>
                        </div>
                        <h3 class="h4 mb-3">Luxury Spa</h3>
                        <p class="text-muted mb-0">Relax and rejuvenate at our full-service spa with expert therapists and premium treatments.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-3">
                <div class="card h-100 border-0 shadow-sm hover-lift">
                    <div class="card-body text-center p-4">
                        <div class="icon-wrapper bg-warning bg-opacity-10 text-warning rounded-circle mx-auto mb-4" style="width: 80px; height: 80px; line-height: 80px;">
                            <i class="fas fa-umbrella-beach fa-2x"></i>
                        </div>
                        <h3 class="h4 mb-3">Beach Access</h3>
                        <p class="text-muted mb-0">Private beach access with premium amenities and exclusive services for our guests.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Room Showcase - Enhanced -->
<section class="py-5 bg-white">
    <div class="container py-5">
        <div class="text-center mb-5">
            <span class="text-warning fw-bold mb-2 d-block">ACCOMMODATIONS</span>
            <h2 class="display-5 fw-bold position-relative d-inline-block">Our Rooms & Suites
                <span class="position-absolute bottom-0 start-50 translate-middle-x bg-warning" style="height: 4px; width: 80px;"></span>
            </h2>
            <p class="lead text-muted mt-3 mx-auto" style="max-width: 700px;">Each space is meticulously designed to provide the ultimate in comfort and luxury</p>
        </div>

        <div class="row g-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 overflow-hidden room-card">
                    <div class="position-relative overflow-hidden" style="height: 300px;">
                        <img src="https://images.unsplash.com/photo-1566669437685-bc1c6dfc8f7f" class="object-fit-cover w-100 h-100" alt="Deluxe Room">
                        <div class="room-overlay d-flex align-items-end">
                            <div class="room-price bg-dark text-white p-3 w-100">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fs-5">From $199/night</span>
                                    <a href="#" class="btn btn-sm btn-warning">View Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h3 class="h4 mb-2">Deluxe Room</h3>
                        <div class="d-flex mb-3">
                            <div class="me-3"><i class="fas fa-user-friends text-warning me-2"></i> 2 Guests</div>
                            <div><i class="fas fa-ruler-combined text-warning me-2"></i> 45 m²</div>
                        </div>
                        <p class="text-muted mb-0">Spacious rooms with modern amenities, plush bedding, and stunning city or garden views.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 overflow-hidden room-card">
                    <div class="position-relative overflow-hidden" style="height: 300px;">
                        <img src="https://images.unsplash.com/photo-1596394516093-501ba68a0ba6" class="object-fit-cover w-100 h-100" alt="Executive Suite">
                        <div class="room-overlay d-flex align-items-end">
                            <div class="room-price bg-dark text-white p-3 w-100">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fs-5">From $399/night</span>
                                    <a href="#" class="btn btn-sm btn-warning">View Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h3 class="h4 mb-2">Executive Suite</h3>
                        <div class="d-flex mb-3">
                            <div class="me-3"><i class="fas fa-user-friends text-warning me-2"></i> 4 Guests</div>
                            <div><i class="fas fa-ruler-combined text-warning me-2"></i> 80 m²</div>
                        </div>
                        <p class="text-muted mb-0">Luxurious suites with separate living areas, premium services, and panoramic city views.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 overflow-hidden room-card">
                    <div class="position-relative overflow-hidden" style="height: 300px;">
                        <img src="https://images.unsplash.com/photo-1578683010236-d716f9a3f461" class="object-fit-cover w-100 h-100" alt="Presidential Suite">
                        <div class="room-overlay d-flex align-items-end">
                            <div class="room-price bg-dark text-white p-3 w-100">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fs-5">From $699/night</span>
                                    <a href="#" class="btn btn-sm btn-warning">View Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h3 class="h4 mb-2">Presidential Suite</h3>
                        <div class="d-flex mb-3">
                            <div class="me-3"><i class="fas fa-user-friends text-warning me-2"></i> 6 Guests</div>
                            <div><i class="fas fa-ruler-combined text-warning me-2"></i> 150 m²</div>
                        </div>
                        <p class="text-muted mb-0">The ultimate in luxury with panoramic views, private terrace, and personalized butler service.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-5">
            <a href="#" class="btn btn-outline-dark btn-lg px-4 py-3">View All Accommodations</a>
        </div>
    </div>
</section>

<!-- Testimonials - Enhanced -->
<section class="py-5 bg-dark text-white position-relative" style="background-image: linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.8)), url('https://images.unsplash.com/photo-1535827841776-24afc1e255ac'); background-size: cover; background-attachment: fixed;">
    <div class="container py-5">
        <div class="text-center mb-5">
            <span class="text-warning fw-bold mb-2 d-block">GUEST EXPERIENCES</span>
            <h2 class="display-5 fw-bold position-relative d-inline-block">What Our Guests Say
                <span class="position-absolute bottom-0 start-50 translate-middle-x bg-warning" style="height: 4px; width: 80px;"></span>
            </h2>
        </div>

        <div class="row g-4">
            <div class="col-lg-6">
                <div class="p-4 rounded-3 bg-white-10 backdrop-blur h-100">
                    <div class="text-warning mb-3">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="fs-5 mb-4 fst-italic">"Absolutely stunning hotel with exceptional service. The attention to detail was remarkable and the staff went above and beyond to make our stay perfect. The spa treatments were world-class!"</p>
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle overflow-hidden me-3" style="width: 60px; height: 60px; background-image: url('https://randomuser.me/api/portraits/women/32.jpg'); background-size: cover;"></div>
                        <div>
                            <h4 class="mb-0">Sarah Johnson</h4>
                            <small class="text-white-50">New York, USA</small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="p-4 rounded-3 bg-white-10 backdrop-blur h-100">
                    <div class="text-warning mb-3">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="fs-5 mb-4 fst-italic">"The best hotel experience I've had in years. The infinity pool at sunset is something you have to see to believe. The executive suite was spacious and luxurious with amazing city views."</p>
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle overflow-hidden me-3" style="width: 60px; height: 60px; background-image: url('https://randomuser.me/api/portraits/men/75.jpg'); background-size: cover;"></div>
                        <div>
                            <h4 class="mb-0">Michael Chen</h4>
                            <small class="text-white-50">Toronto, Canada</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Gallery - Enhanced -->
<section class="py-5 bg-light">
    <div class="container py-5">
        <div class="text-center mb-5">
            <span class="text-warning fw-bold mb-2 d-block">GALLERY</span>
            <h2 class="display-5 fw-bold position-relative d-inline-block">Moments at Our Hotel
                <span class="position-absolute bottom-0 start-50 translate-middle-x bg-warning" style="height: 4px; width: 80px;"></span>
            </h2>
            <p class="lead text-muted mt-3 mx-auto" style="max-width: 700px;">Capturing the essence of luxury and unforgettable experiences</p>
        </div>

        <div class="row g-3">
            <div class="col-md-4 col-6">
                <div class="gallery-item rounded-3 overflow-hidden hover-zoom position-relative">
                    <img src="https://images.unsplash.com/photo-1520250497591-112f2f40a3f4" class="object-fit-cover w-100" style="height: 300px;" alt="Hotel lobby">
                    <div class="gallery-caption position-absolute bottom-0 start-0 w-100 p-3 text-white">
                        <h5 class="mb-0">Grand Lobby</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-6">
                <div class="gallery-item rounded-3 overflow-hidden hover-zoom position-relative">
                    <img src="https://images.unsplash.com/photo-1535827841776-24afc1e255ac" class="object-fit-cover w-100" style="height: 300px;" alt="Restaurant">
                    <div class="gallery-caption position-absolute bottom-0 start-0 w-100 p-3 text-white">
                        <h5 class="mb-0">Gourmet Restaurant</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-6">
                <div class="gallery-item rounded-3 overflow-hidden hover-zoom position-relative">
                    <img src="https://images.unsplash.com/photo-1571896349842-33c89424de2d" class="object-fit-cover w-100" style="height: 300px;" alt="Pool area">
                    <div class="gallery-caption position-absolute bottom-0 start-0 w-100 p-3 text-white">
                        <h5 class="mb-0">Infinity Pool</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-8 col-6">
                <div class="gallery-item rounded-3 overflow-hidden hover-zoom position-relative">
                    <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945" class="object-fit-cover w-100" style="height: 300px;" alt="Room interior">
                    <div class="gallery-caption position-absolute bottom-0 start-0 w-100 p-3 text-white">
                        <h5 class="mb-0">Luxury Suite</h5>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-12">
                <div class="gallery-item rounded-3 overflow-hidden hover-zoom position-relative">
                    <img src="https://images.unsplash.com/photo-1564501049412-61c2a3083791" class="object-fit-cover w-100" style="height: 300px;" alt="Spa">
                    <div class="gallery-caption position-absolute bottom-0 start-0 w-100 p-3 text-white">
                        <h5 class="mb-0">Wellness Spa</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action - Enhanced -->
<section class="py-5 bg-warning position-relative overflow-hidden">
    <div class="cta-pattern position-absolute top-0 start-0 w-100 h-100"></div>
    <div class="container py-5 text-center position-relative">
        <h2 class="display-5 fw-bold mb-4">Ready for an unforgettable experience?</h2>
        <p class="fs-4 mb-5">Book your stay today and discover luxury redefined</p>
        <div class="d-flex justify-content-center gap-3 flex-wrap">
            <a href="{{ route('register') }}" class="btn btn-dark btn-lg px-4 py-3 rounded-pill hover-lift">
                <i class="fas fa-calendar-check me-2"></i> Book Now
            </a>
            <a href="tel:+18005551234" class="btn btn-outline-dark btn-lg px-4 py-3 rounded-pill hover-lift">
                <i class="fas fa-phone me-2"></i> +1 (800) 555-1234
            </a>
            <a href="mailto:reservations@luxuryhotel.com" class="btn btn-outline-dark btn-lg px-4 py-3 rounded-pill hover-lift">
                <i class="fas fa-envelope me-2"></i> Email Us
            </a>
        </div>
    </div>
</section>

<!-- Custom Styles -->
<style>
    /* Updated Hero Section Styles */
    .hero-section {
        position: relative;
    }

    .hero-image-overlay {
        background: linear-gradient(to bottom, rgba(0,0,0,0.3) 0%, rgba(0,0,0,0.7) 100%);
    }

    .hero-image {
        z-index: -1;
    }

    .hero-image img {
        object-fit: cover;
        width: 100%;
        height: 100%;
    }

    .scroll-indicator .chevron {
        width: 20px;
        height: 20px;
        border-bottom: 2px solid white;
        border-right: 2px solid white;
        transform: rotate(45deg);
        margin: -10px;
        animation: scroll 2s infinite;
    }

    .scroll-indicator .chevron:nth-child(2) {
        animation-delay: 0.2s;
    }

    .scroll-indicator .chevron:nth-child(3) {
        animation-delay: 0.4s;
    }

    @keyframes scroll {
        0% {
            opacity: 0;
            transform: rotate(45deg) translate(-20px, -20px);
        }
        50% {
            opacity: 1;
        }
        100% {
            opacity: 0;
            transform: rotate(45deg) translate(20px, 20px);
        }
    }

    /* Feature Cards */
    .hover-lift {
        transition: all 0.3s ease;
    }

    .hover-lift:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1) !important;
    }

    .icon-wrapper {
        transition: all 0.3s ease;
    }

    .card:hover .icon-wrapper {
        transform: rotateY(180deg);
        background-color: #ffc107 !important;
        color: #000 !important;
    }

    /* Room Cards */
    .room-card {
        transition: all 0.3s ease;
    }

    .room-card:hover {
        transform: translateY(-5px);
    }

    .room-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, transparent 100%);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .room-card:hover .room-overlay {
        opacity: 1;
    }

    .room-price {
        transform: translateY(100%);
        transition: transform 0.3s ease;
    }

    .room-card:hover .room-price {
        transform: translateY(0);
    }

    /* Gallery */
    .gallery-item {
        transition: all 0.3s ease;
    }

    .gallery-caption {
        background: linear-gradient(to top, rgba(0,0,0,0.8) 0%, transparent 100%);
        transform: translateY(100%);
        transition: transform 0.3s ease;
    }

    .gallery-item:hover .gallery-caption {
        transform: translateY(0);
    }

    .hover-zoom img {
        transition: transform 0.5s ease;
    }

    .hover-zoom:hover img {
        transform: scale(1.1);
    }

    /* Testimonials */
    .backdrop-blur {
        backdrop-filter: blur(10px);
    }

    .bg-white-10 {
        background-color: rgba(255, 255, 255, 0.1);
    }

    /* CTA Section */
    .cta-pattern {
        background-image: radial-gradient(rgba(0,0,0,0.1) 2px, transparent 2px);
        background-size: 20px 20px;
        opacity: 0.3;
    }
</style>

<!-- JavaScript -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize animations
        const animateOnScroll = function() {
            const elements = document.querySelectorAll('.card, .gallery-item, .testimonial');
            const windowHeight = window.innerHeight;

            elements.forEach(element => {
                const elementPosition = element.getBoundingClientRect().top;
                const elementVisible = 150;

                if (elementPosition < windowHeight - elementVisible) {
                    element.classList.add('animate__animated', 'animate__fadeInUp');
                }
            });
        };

        // Run once on load and then on scroll
        animateOnScroll();
        window.addEventListener('scroll', animateOnScroll);
    });
</script>
@endsection
