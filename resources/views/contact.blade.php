@extends('layouts.user-dashboard')

@section('content')
    <link rel="stylesheet" href="{{ asset('css/contact.css') }}">

    <div class="contact-page-wrap">

        <div class="contact-topbar">
            <h2>Contact Us</h2>
        </div>

        <div class="contact-hero">
            <h1>We&rsquo;d love to <em>hear from you</em></h1>
            <p>Got a question, need help or just want to say hello?
            </p>
        </div>

        <div class="contact-main">

            <div class="contact-info-panel">

                {{-- INFO CARD --}}
                <div class="info-card">
                    <div class="info-card-header">Our Info</div>

                    <div class="info-item">
                        <div class="info-icon">
                            <svg viewBox="0 0 24 24">
                                <path
                                    d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07A19.5 19.5 0 013.07 9.8a19.79 19.79 0 01-3.07-8.68A2 2 0 012 .82h3a2 2 0 012 1.72c.127.96.361 1.903.7 2.81a2 2 0 01-.45 2.11L6.09 8.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0122 16.92z" />
                            </svg>
                        </div>
                        <div>
                            <div class="info-label">Phone</div>
                            <div class="info-value"> +94 11 234 5678</a></div>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon">
                            <svg viewBox="0 0 24 24">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                                <polyline points="22,6 12,13 2,6" />
                            </svg>
                        </div>
                        <div>
                            <div class="info-label">Email</div>
                            <div class="info-value"><a href="mailto:hello@guidemate.lk">hello@guidemate.lk</a></div>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon">
                            <svg viewBox="0 0 24 24">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z" />
                                <circle cx="12" cy="10" r="3" />
                            </svg>
                        </div>
                        <div>
                            <div class="info-label">Location</div>
                            <div class="info-value">42 Main Street,<br>Dewalapola, Sri Lanka</div>
                        </div>
                    </div>
                </div>

                {{-- SOCIAL LINKS --}}
                <div class="info-card">
                    <div class="info-card-header">Follow Us</div>
                    <div class="social-links">
                        <a href="#" class="social-link" title="Facebook">
                            <svg viewBox="0 0 24 24">
                                <path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z" />
                            </svg>
                        </a>
                        <a href="#" class="social-link" title="Instagram">
                            <svg viewBox="0 0 24 24">
                                <rect x="2" y="2" width="20" height="20" rx="5" ry="5" />
                                <path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z" />
                                <line x1="17.5" y1="6.5" x2="17.51" y2="6.5" />
                            </svg>
                        </a>
                        <a href="#" class="social-link" title="Twitter / X">
                            <svg viewBox="0 0 24 24">
                                <path
                                    d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z" />
                            </svg>
                        </a>
                        <a href="#" class="social-link" title="YouTube">
                            <svg viewBox="0 0 24 24">
                                <path
                                    d="M22.54 6.42a2.78 2.78 0 00-1.95-1.96C18.88 4 12 4 12 4s-6.88 0-8.59.46a2.78 2.78 0 00-1.95 1.96A29 29 0 001 12a29 29 0 00.46 5.58 2.78 2.78 0 001.95 1.95C5.12 20 12 20 12 20s6.88 0 8.59-.47a2.78 2.78 0 001.95-1.95A29 29 0 0023 12a29 29 0 00-.46-5.58z" />
                                <polygon points="9.75 15.02 15.5 12 9.75 8.98 9.75 15.02" />
                            </svg>
                        </a>
                    </div>
                </div>

            </div>

            {{-- FORM CARD --}}
            <div class="contact-form-card">
                <div class="form-card-title">Send us a message</div>

                @if (session('success'))
                    <div class="success-msg">{{ session('success') }}</div>
                @endif

                <form method="POST" action="{{ route('contact.send') }}">
                    @csrf

                    <div class="form-row">
                        <div class="form-group">
                            <label for="name">Your Name</label>
                            <input type="text" id="name" name="name" placeholder="Your Name" required
                                value="{{ old('name') }}">
                        </div>
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" id="email" name="email" placeholder="you@example.com" required
                                value="{{ old('email') }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="subject">Subject</label>
                        <select id="subject" name="subject">
                            <option value="" disabled selected>Select a topic…</option>
                            <option value="guide">Place Request</option>
                            <option value="guide">Guide Request</option>
                            <option value="feedback">Feature &amp; Suggestions</option>
                            <option value="feedback">Feedback &amp; Suggestions</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="message">Your Message</label>
                        <textarea id="message" name="message" placeholder="Tell us how we can help you…" required>{{ old('message') }}</textarea>
                    </div>

                    <button type="submit" class="submit-btn">
                        Send Message
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
