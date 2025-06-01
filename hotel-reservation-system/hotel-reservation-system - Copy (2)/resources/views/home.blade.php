@extends('layouts.app')

@section('content')
<div class="welcome-container">
    <!-- Hero Section -->
    <div class="hero-section">
        <div class="hero-overlay"></div>
        <div class="hero-content text-center text-white">
            <h1 class="display-4 fw-bold">Welcome to Grand Horizon Hotel</h1>
            <p class="lead">Luxury, Comfort, and Unforgettable Experiences</p>
            <div class="mt-4">
                <a href="{{ route('register') }}" class="btn btn-primary btn-lg px-4 me-2">Book Now</a>
                <a href="#rooms" class="btn btn-outline-light btn-lg px-4">Explore Rooms</a>
            </div>
        </div>
    </div>

    <!-- Quick Booking Widget -->
    <div class="container quick-booking py-4">
        <div class="row g-3">
            <div class="col-md-3">
                <label for="check-in" class="form-label">Check-In</label>
                <input type="date" class="form-control" id="check-in">
            </div>
            <div class="col-md-3">
                <label for="check-out" class="form-label">Check-Out</label>
                <input type="date" class="form-control" id="check-out">
            </div>
            <div class="col-md-2">
                <label for="adults" class="form-label">Adults</label>
                <select class="form-select" id="adults">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                </select>
            </div>
            <div class="col-md-2">
                <label for="children" class="form-label">Children</label>
                <select class="form-select" id="children">
                    <option value="0">0</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                </select>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button class="btn btn-primary w-100">Check Availability</button>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="container py-5">
        <div class="row text-center">
            <div class="col-md-4 feature-item">
                <i class="fas fa-wifi fa-3x mb-3"></i>
                <h3>Free WiFi</h3>
                <p>High-speed internet throughout the hotel</p>
            </div>
            <div class="col-md-4 feature-item">
                <i class="fas fa-utensils fa-3x mb-3"></i>
                <h3>Restaurant</h3>
                <p>Gourmet dining with local and international cuisine</p>
            </div>
            <div class="col-md-4 feature-item">
                <i class="fas fa-swimming-pool fa-3x mb-3"></i>
                <h3>Pool & Spa</h3>
                <p>Relax in our luxurious wellness facilities</p>
            </div>
        </div>
    </div>

    <!-- Rooms Section -->
    <div id="rooms" class="container-fluid bg-light py-5">
        <div class="container">
            <h2 class="text-center mb-5">Our Rooms & Suites</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card room-card">
                        <img src="https://via.placeholder.com/400x300" class="card-img-top" alt="Deluxe Room">
                        <div class="card-body">
                            <h5 class="card-title">Deluxe Room</h5>
                            <p class="card-text">Spacious rooms with stunning city or garden views</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="price">$199/night</span>
                                <a href="#" class="btn btn-sm btn-outline-primary">View Details</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card room-card">
                        <img src="https://via.placeholder.com/400x300" class="card-img-top" alt="Executive Suite">
                        <div class="card-body">
                            <h5 class="card-title">Executive Suite</h5>
                            <p class="card-text">Luxurious suites with separate living area</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="price">$299/night</span>
                                <a href="#" class="btn btn-sm btn-outline-primary">View Details</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card room-card">
                        <img src="https://via.placeholder.com/400x300" class="card-img-top" alt="Presidential Suite">
                        <div class="card-body">
                            <h5 class="card-title">Presidential Suite</h5>
                            <p class="card-text">Ultimate luxury with panoramic city views</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="price">$499/night</span>
                                <a href="#" class="btn btn-sm btn-outline-primary">View Details</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center mt-4">
                <a href="#" class="btn btn-primary">View All Rooms</a>
            </div>
        </div>
    </div>

    <!-- Testimonials -->
    <div class="container py-5">
        <h2 class="text-center mb-5">What Our Guests Say</h2>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card testimonial-card">
                    <div class="card-body">
                        <div class="d-flex mb-3">
                            <img src="https://via.placeholder.com/50" class="rounded-circle me-3" alt="Guest">
                            <div>
                                <h5 class="mb-0">John Smith</h5>
                                <div class="text-warning">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                            </div>
                        </div>
                        <p class="card-text">"The service was exceptional and the room was spotless. Will definitely return!"</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card testimonial-card">
                    <div class="card-body">
                        <div class="d-flex mb-3">
                            <img src="https://via.placeholder.com/50" class="rounded-circle me-3" alt="Guest">
                            <div>
                                <h5 class="mb-0">Sarah Johnson</h5>
                                <div class="text-warning">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                </div>
                            </div>
                        </div>
                        <p class="card-text">"The spa treatments were amazing and the staff went above and beyond."</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card testimonial-card">
                    <div class="card-body">
                        <div class="d-flex mb-3">
                            <img src="https://via.placeholder.com/50" class="rounded-circle me-3" alt="Guest">
                            <div>
                                <h5 class="mb-0">Michael Brown</h5>
                                <div class="text-warning">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                            </div>
                        </div>
                        <p class="card-text">"Perfect location with stunning views. The executive suite was worth every penny."</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Section -->
    <div class="container-fluid bg-dark text-white py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h4>Contact Us</h4>
                    <p><i class="fas fa-map-marker-alt me-2"></i> 123 Luxury Avenue, City Center</p>
                    <p><i class="fas fa-phone me-2"></i> +1 (555) 123-4567</p>
                    <p><i class="fas fa-envelope me-2"></i> info@grandhorizon.com</p>
                </div>
                <div class="col-md-4">
                    <h4>Opening Hours</h4>
                    <p>Reception: 24/7</p>
                    <p>Restaurant: 7:00 AM - 11:00 PM</p>
                    <p>Spa: 9:00 AM - 9:00 PM</p>
                </div>
                <div class="col-md-4">
                    <h4>Newsletter</h4>
                    <p>Subscribe for special offers</p>
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" placeholder="Your Email">
                        <button class="btn btn-primary" type="button">Subscribe</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .hero-section {
        background: url('https://via.placeholder.com/1920x1080') no-repeat center center;
        background-size: cover;
        height: 70vh;
        position: relative;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .hero-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
    }
    .hero-content {
        position: relative;
        z-index: 1;
    }
    .quick-booking {
        background: white;
        border-radius: 8px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        margin-top: -50px;
        position: relative;
        z-index: 2;
    }
    .feature-item {
        padding: 20px;
        transition: all 0.3s ease;
    }
    .feature-item:hover {
        transform: translateY(-10px);
    }
    .room-card {
        transition: all 0.3s ease;
        height: 100%;
    }
    .room-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
    .price {
        font-weight: bold;
        color: #0d6efd;
        font-size: 1.2rem;
    }
    .testimonial-card {
        height: 100%;
    }
</style>

@endsection
