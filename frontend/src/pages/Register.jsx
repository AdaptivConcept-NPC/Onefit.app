import React from 'react';
import { Link } from 'react-router-dom';
import RegistrationForm from '../components/RegistrationForm';
import PlanComparisonTable from '../components/PlanComparisonTable';
import MembershipCards from '../components/MembershipCards';

const Register = () => {
    return (
        <div className="h-100 no-scroller" style={{ maxHeight: '100vh !important', overflowY: 'auto' }}>
            {/* Navigation bar */}
            <nav className="navbar navbar-light sticky-top navbar-style">
                <div className="container-fluid">
                    <Link className="navbar-brand fs-1 text-white comfortaa-font" to="/">One<span
                        style={{ color: 'var(--primary-color)' }}>fit</span>.app<span
                            style={{ fontSize: '10px' }}>&trade;</span></Link>
                    <button className="navbar-toggler shadow onefit-buttons-style-dark bg-transparent p-4" type="button"
                        data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                        <span className="material-icons material-icons-round align-middle" style={{ fontSize: '28px!important' }}>
                            public
                        </span>
                    </button>
                    <div className="offcanvas offcanvas-end offcanvas-menu-primary-style" tabIndex="-1" id="offcanvasNavbar"
                        aria-labelledby="offcanvasNavbarLabel">
                        <div id="offcanvas-menu" className="pb-4" style={{ borderRadius: '0 0 25px 25px', overflow: 'hidden' }}>
                            <div className="offcanvas-header fs-1"
                                style={{ backgroundColor: 'var(--secondary-color)', color: '#fff' }}>
                                <h5 className="offcanvas-title" id="offcanvasNavbarLabel"><img
                                    src="/media/assets/One-Symbol-Logo-White.svg" alt=""
                                    className="img-fluid logo-size-2" /> Navigation</h5>
                                <button type="button" className="onefit-buttons-style-light rounded-pill shadow p-2"
                                    data-bs-dismiss="offcanvas" aria-label="Close">
                                    <span className="material-icons material-icons-round align-middle">
                                        close
                                    </span>
                                </button>
                            </div>
                            <div className="offcanvas-body pb-4 top-down-grad-dark" style={{ maxHeight: '100vh' }}>
                                <ul className="navbar-nav justify-content-end flex-grow-1 pe-3 comfortaa-font fs-3 h-100"
                                    style={{ overflowY: 'auto' }}>
                                    <li className="nav-item d-grid">
                                        <p className="text-white text-center" style={{ fontSize: '10px' }}>Get started with your
                                            fitness
                                            journey by
                                            signing up for a free community account or subscribe to our Premium offering to
                                            get
                                            access to
                                            Pro.Athlete level fitness tracking resources, guides, physical trainer and
                                            community
                                            support.</p>
                                        <Link className="onefit-buttons-style-light p-4 text-center text-decoration-none shadow fw-bold fs-5"
                                            to="/register"
                                            style={{ borderRadius: '25px !important', fontSize: '20px !important', transform: 'scale(1)!important', color: 'var(--secondary-color)!important' }}>Register
                                            your account.
                                            <i className="fas fa-file-signature"></i>
                                        </Link>
                                    </li>
                                    <hr className="text-white" />
                                    <li className="nav-item">
                                        <a className="nav-link active p-4" href="https://onefitnet.co.za/" aria-current="page"
                                            style={{ borderRadius: '25px !important' }}>Home</a>
                                    </li>
                                    {/* Additional items omitted for brevity */}
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
            {/* ./ Navigation bar */}

            <div className="row align-items-center m-0">
                <div className="col-xl py-4">
                    {/* collapsable logo panel */}
                    <div id="collapseLogoPanel"
                        className="content-panel-border-style p-4 darkpads-bg-container text-center shadow collapse multi-collapse show w3-animate-top"
                        style={{ borderRadius: '25px' }}>
                        <img src="/media/assets/One-Logo-Vertical.svg" className="img-fluid my-4 screenz" alt="one fitness"
                            style={{ maxHeight: '50vh' }} />

                        <p className="my-4 text-center comfortaa-font" style={{ color: '#fff', fontSize: '10px' }}>Crafted by
                            AdaptivConcept FL &copy;
                            2021. All rights reserved.</p>
                    </div>
                    {/* ./ collapsable logo panel */}

                    {/* collapsable plan comparison table panel */}
                    <PlanComparisonTable />
                    {/* ./ collapsable plan comparison table panel */}
                </div>
                <div className="col-xl py-4 text-center"
                    style={{ maxHeight: '90vh', overflowY: 'auto', overflowX: 'hidden', borderRadius: '25px' }}>
                    <div className="content-panel-border-style registration-form tunnel-bg mb-4 shadow p-4"
                        style={{ width: '100%', borderRadius: '25px', backgroundColor: 'var(--secondary-color)' }}>
                        <h2 className="text-center fs-1 pt-4" style={{ color: 'var(--primary-color)' }}><i
                            className="fas fa-file-signature"></i> Sign
                            up for a
                            Community
                            account, it's free.</h2>
                        <p>Get free access to tons of Fitness, Health and Lifestyle related Resources, News, Blogs and
                            Shopping
                            Content
                            with the Community Account. We also offer Community Members checkout discounts on selected
                            One<span style={{ color: 'var(--primary-color)' }}>fit</span>.Store Products
                            and Services. Sign up today to start the meaningful and insightful fitness journey that you have
                            always been
                            looking for.</p>
                        <hr className="mx-4 bg-white" />

                        {/* Registration Form Component */}
                        <RegistrationForm />

                        <hr className="text-white" />

                        <div className="my-4">
                            {/* Membership Sales Card Grid */}
                            <p className="text-center">Or Sign Up for</p>
                            <h5 className="fs-1 d-grid fw-bold text-center my-4" style={{ color: 'var(--white)' }}>
                                <span className="material-icons material-icons-round"
                                    style={{ fontSize: '80px!important', color: 'var(--primary-color)' }}>
                                    verified_user
                                </span>
                                <span><strong style={{ color: 'var(--primary-color)' }}>Pro</strong>.Membership</span>
                            </h5>

                            {/* multi-collapse left panels to toggle membership plan comparison table */}
                            <button className="onefit-buttons-style-tahiti shadow p-4 mt-0 mb-5" type="button"
                                data-bs-toggle="collapse" data-bs-target=".multi-collapse" aria-expanded="true"
                                aria-controls="collapseLogoPanel collapsePlanCompTblPanel">
                                Compare Plans.
                            </button>

                            <MembershipCards />
                            {/* Membership Sales Card Grid */}
                        </div>

                    </div>
                </div>
            </div>

            <div className="text-center fixed-bottom p-4" style={{ background: '#ffa500', color: 'var(--secondary-color)' }} hidden>
                <p>Crafted by AdaptivConcept FL &copy; 2021. All rights reserved.</p>
            </div>
        </div>
    );
};

export default Register;
