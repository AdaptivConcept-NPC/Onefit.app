
import React from 'react';
import { Link } from 'react-router-dom';
import Footer from '../components/Footer';
import LatestTrainingSection from '../components/LatestTrainingSection';
import HomeContent from '../components/HomeContent';

const Landing = () => {
    return (
        <div className="noselect">
            {/* Navigation bar */}
            <nav className="navbar navbar-light stickyz fixed-top navbar-style bg-transparent top-down-grad-dark"
                style={{ zIndex: 10000 }}>
                <div className="container-fluid">
                    <a className="navbar-brand fs-1 text-white comfortaa-font" href="#">One<span
                        style={{ color: 'var(--primary-color)' }}>fit</span>.app<span style={{ fontSize: '10px' }}>&trade;</span></a>
                    <button className="navbar-toggler shadow onefit-buttons-style-dark bg-transparent p-4" type="button"
                        data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
                        <span className="material-icons material-icons-round align-middle" style={{ fontSize: '28px !important' }}>
                            public
                        </span>
                    </button>
                    <div className="offcanvas offcanvas-end offcanvas-menu-primary-style" tabIndex="-1" id="offcanvasNavbar"
                        aria-labelledby="offcanvasNavbarLabel">
                        <div id="offcanvas-menu" className="pb-4" style={{ borderRadius: '0 0 25px 25px', overflow: 'hidden' }}>
                            <div className="offcanvas-header fs-1" style={{ backgroundColor: 'var(--secondary-color)', color: '#fff' }}>
                                <img src="/media/assets/One-Logo.svg" alt="" className="img-fluid logo-size-2"
                                    style={{ maxWidth: '100px' }} />
                                <h5 className="offcanvas-title text-center" id="offcanvasNavbarLabel">
                                    <span className="material-icons material-icons-round align-middle"
                                        style={{ color: 'var(--primary-color)', cursor: 'pointer', fontSize: '20px !important' }}>
                                        public
                                    </span>
                                    Web.
                                </h5>
                                <button type="button" className="onefit-buttons-style-light rounded-pill shadow p-2"
                                    data-bs-dismiss="offcanvas" aria-label="Close">
                                    <span className="material-icons material-icons-round align-middle"
                                        style={{ fontSize: '20px !important' }}> close </span>
                                </button>
                            </div>
                            <div className="offcanvas-body pb-4 top-down-grad-dark" style={{ maxHeight: '100vh' }}>
                                <ul className="navbar-nav justify-content-end flex-grow-1 pe-3 comfortaa-font fs-3 h-100"
                                    style={{ overflowY: 'auto' }}>
                                    <li className="nav-item d-grid">
                                        <p className="text-white text-center" style={{ fontSize: '10px' }}>Get started with your fitness
                                            journey by
                                            signing up for a free community account or subscribe to our Premium offering to get
                                            access to
                                            Pro.Athlete level fitness tracking resources, guides, physical trainer and community
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
                                    {/* Additional links omitted for brevity */}
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            {/* Banner */}
            <div className="text-center pb-4" style={{ paddingTop: '150px' }}>
                <div className="d-grid mb-2 w3-animate-top">
                    <p className="text-white comfortaa-font fs-4 mb-0 fw-bold"> Presented by </p>
                    <p className="text-white audiowide-font mt-1 mb-4 fw-bold" style={{ fontSize: '8px !important' }}>
                        <span style={{ color: 'var(--primary-color)' }}>
                            One</span>-On-<span style={{ color: 'var(--primary-color)' }}>One</span> Fitness Network<sup
                                style={{ color: 'var(--primary-color)' }}>&reg;</sup>
                    </p>
                    <span className="material-icons material-icons-round" style={{ color: 'var(--primary-color)', cursor: 'pointer' }}>
                        public
                    </span>
                </div>

                <img src="/media/assets/One-Logo-Vertical.png" className="border-5 border-start border-end p-4 down-top-grad-dark"
                    alt="Onefit™.app Logo"
                    style={{ maxHeight: '50vh', width: 'auto !important', borderRadius: '25px', backgroundColor: 'var(--secondary-color)' }} />
            </div>

            {/* Slogan */}
            <div className="text-center p-4 comfortaa-font fw-bold fs-1 sticky-top"
                style={{ color: 'var(--text-color)', backgroundColor: 'rgba(52, 55, 52, 0.8)', margin: '40px 0' }}>
                <span style={{ color: 'var(--white)' }}>
                    #One<span style={{ color: 'var(--primary-color)' }}>fitness</span>ForAll
                </span>
            </div>

            {/* Login Section */}
            <main className="container-fluid m-0 down-top-grad-dark">
                <div className="container text-center text-white mt-4 border-5z border-topz"
                    style={{ minHeight: '50vh', paddingBottom: '40px', borderRadius: '25px' }}>

                    <div className="row align-items-center p-0 darkpads-bg-container shadow"
                        style={{ borderRadius: '25px', backgroundColor: 'rgba(52, 52, 52, 0.8)' }}>
                        <div className="col-xlg d-flex justify-content-center py-5 top-down-grad-dark"
                            style={{ borderRadius: '25px !important' }}>
                            <form className="text-center text-white comfortaa-font align-middle" method="post"
                                action="#" autoComplete="off"
                                style={{ maxWidth: '50vw' }}>

                                <div id="sign-in-heading">
                                    <span className="material-icons material-icons-round"
                                        style={{ fontSize: '100px !important', color: '#fff !important' }}>
                                        fingerprint </span>
                                    <h1 className="py-0 px-4 text-truncate"
                                        style={{ color: '#fff', fontSize: '40px', borderRadius: '00 25px 25px !important' }}>
                                        Members<span style={{ color: 'var(--primary-color)' }}>.</span></h1>
                                </div>
                                <hr />
                                <div className="mb-3">
                                    <label htmlFor="onefitUserEmail" className="form-label fs-4">Email address</label>
                                    <input type="email" className="form-controlz form-control-text-input shadow p-2"
                                        id="onefitUserEmail" name="onefitUserEmail" aria-describedby="emailHelp" />
                                </div>
                                <div className="mb-4">
                                    <label htmlFor="onefitUserPassword" className="form-label fs-4">Password</label>
                                    <input type="password" className="form-controlz form-control-text-input shadow text-center p-2"
                                        id="onefitUserPassword" name="onefitUserPassword" />
                                </div>
                                <div className="mt-4 d-grid gap-2">
                                    <button type="submit" className="tnz onefit-buttons-style-light shadow align-items-center p-4">
                                        <span className="align-middle" style={{ fontSize: '20px !important' }}>
                                            <span className="align-middle">Sign in.</span>
                                            <span className="material-icons material-icons-round align-middle"
                                                style={{ fontSize: '25px !important', color: 'var(--primary-color)' }}>
                                                login
                                            </span>
                                        </span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </main>


            <div className="container-fluid top-down-grad-tahiti" style={{ borderRadius: '25px 25px 0 0', overflow: 'hidden', marginTop: '-25px' }}>
                {/* Latest Training Section */}
                <LatestTrainingSection />

                {/* Main Content */}
                <HomeContent />

                {/* Footer */}
                <Footer />
            </div>
        </div >
    );
};

export default Landing;
