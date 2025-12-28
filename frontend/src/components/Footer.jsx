
import React, { useState } from 'react';

const Footer = () => {
    // Placeholder functions (can be expanded later)
    const launchLink = (url) => {
        window.open(url, '_blank');
    };

    const playVideo = () => {
        console.log("Play video clicked");
        // Logic to play video or open modal
    };

    return (
        <div className="navbar navbar-dark fixed-bottom navbar-stylez down-top-grad-dark py-4 justify-content-center">
            <div className="no-scroller shadow border-5 border-start border-end mx-4 px-3 collapse top-down-grad-tahiti"
                style={{
                    overflowY: 'auto',
                    borderRadius: '25px',
                    marginBottom: '40px',
                    paddingTop: '100px',
                    maxHeight: '90vh',
                    borderColor: 'rgb(255, 165, 0)'
                }}
                id="navbarToggleExternalContent">
                <div className="p-0">
                    <div className="text-center pt-4 mb-4 top-down-grad-dark" style={{ borderRadius: '25px 25px 0 0' }}>
                        <img src="/media/assets/One-Symbol-Logo-White.svg" alt="logo"
                            className="img-fluid my-4 p-4 my-pulse-animation-light"
                            style={{ maxWidth: '150px', borderRadius: '25px' }} />
                    </div>

                    {/* Onefit.TV Horizontal Content Stream */}
                    <div className="mb-4" id="onefittv-footer-h-content-stream">
                        <div className="content-panel-border-stylez p-4 shadow border-5 border-start border-end text-white"
                            style={{
                                paddingBottom: '40px',
                                borderRadius: '25px',
                                backgroundColor: 'var(--secondary-color)',
                                borderColor: 'var(--primary-color)'
                            }}>

                            <h5 className="fs-1 h4 aligh-middle d-grid text-center"
                                style={{ color: 'var(--primary-color)' }}>
                                <span className="material-icons material-icons-outlined" style={{ color: '#fff' }}> tv
                                </span>
                                <span>OnefitNet.TV</span>
                            </h5>
                            <hr className="text-white" />

                            <p className="my-4 text-center" style={{ fontSize: '10px' }}>Latest Training Programs |
                                <span className="comfortaa-font" style={{ color: 'var(--primary-color)' }}>OnefitNet.TV</span>
                            </p>

                            <div className="d-lg-none w3-animate-bottom">
                                <div className="video-card-container">
                                    <img src="/media/assets/YouTube Thumbnail 1280x720 px.gif" alt="latest video"
                                        className="img-fluid shadow m-0" style={{ borderRadius: '15px' }} />
                                    <button className="onefit-buttons-style-light shadow-lg play-btn p-2 aligh-middle"
                                        onClick={playVideo}>
                                        <span className="material-icons material-icons-round aligh-middle"
                                            style={{ fontSize: '20px' }}>
                                            play_circle_outline
                                        </span>
                                    </button>
                                </div>

                                <div className="d-grid mt-4 w-100 justify-content-center">
                                    <button
                                        className="onefit-buttons-style-dark shadow d-grid p-4 comfortaa-font text-center aligh-middle position-relative">
                                        <span>View Playlist.</span>
                                        <span
                                            className="material-icons material-icons-round aligh-middle">playlist_play</span>

                                        <span
                                            className="position-absolute top-0 start-100 translate-middle p-2 comfortaa-font border border-light rounded-pill align-middle shadow"
                                            style={{
                                                backgroundColor: 'var(--secondary-color)',
                                                color: 'var(--primary-color)',
                                                borderColor: 'var(--primary-color)'
                                            }}>
                                            <span className="align-middle" style={{ fontSize: '10px' }}>+3</span>
                                            <span className="visually-hidden">Latest Video Count</span>
                                        </span>
                                    </button>
                                </div>
                            </div>


                            <div className="horizontal-scroll d-none d-lg-block w3-animate-bottom">
                                <div className="horizontal-scroll-card p-4">
                                    <img src="/media/assets/YouTube Thumbnail 1280x720 px.gif" alt="placeholder"
                                        className="img-fluid mb-4" style={{ borderRadius: '25px' }} />
                                    <hr className="text-white" style={{ height: '5px' }} />

                                    <div className="row my-2 align-items-center">
                                        <div className="col-sm-2 text-center">
                                            <img src="/media/assets/icons/icons8-sports-mode-50.png"
                                                className="img-fluid p-4" alt="placeholder"
                                                style={{ borderRadius: '5px', backgroundColor: 'var(--primary-color)' }} />
                                        </div>
                                        <div className="col-sm">
                                            <h5>Ep.1 - Best Resistence Exercises | Head Trainer.: Lehlohonolo
                                                Matsoso
                                            </h5>
                                            <p className="align-middle comfortaa-font"><span
                                                className="material-icons material-icons-round"
                                                style={{ fontSize: '20px' }}>timer</span> Duration: 1
                                                hour
                                            </p>
                                            <p className="align-middle comfortaa-font"><span
                                                className="material-icons material-icons-round"
                                                style={{ fontSize: '20px' }}>category</span>
                                                Category: Resistence
                                            </p>

                                            <button
                                                className="onefit-buttons-style-dark shadow p-4 mt-4 comfortaa-font">
                                                Subscribe on <span className="comfortaa-font"
                                                    style={{ color: 'var(--primary-color)' }}>OnefitNet.TV</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                {/* Duplicates omitted for brevity/simplicity, can add more cards if needed */}
                            </div>
                        </div>
                    </div>
                    {/* ./ Onefit.TV Horizontal Content Stream */}

                    <div className="row mt-4 text-center">

                        <div className="col-lg mb-4">
                            <div className="content-panel-border-style p-4 h-100"
                                style={{ paddingBottom: '40px', borderRadius: '25px', backgroundColor: 'var(--secondary-color)' }}>
                                <span className="material-icons material-icons-outlined" style={{ color: '#fff' }}>tag</span>
                                <h5 className="fs-1 h4" style={{ color: 'var(--primary-color)' }}>Social</h5>
                                <hr className="text-white" />
                                <ul className="list-group bg-transparent comfortaa-font">
                                    <li className="list-group-item bg-transparent border-0 social-link-icon-insta my-2 shadow"
                                        style={{ cursor: 'pointer' }} onClick={() => launchLink('https://www.instagram.com/onefit_net')}>
                                        <div className="row align-items-center">
                                            <div className="col-4 text-end">
                                                <i className="fab fa-instagram" style={{ fontSize: '40px' }}
                                                    aria-hidden="true"></i>
                                            </div>
                                            <div className="col text-center" style={{ color: 'var(--primary-color)' }}>
                                                |
                                            </div>
                                            <div className="col text-start">
                                                @onefit_net
                                            </div>
                                        </div>
                                    </li>
                                    <li className="list-group-item bg-transparent border-0 social-link-icon-twitter my-2 shadow"
                                        style={{ cursor: 'pointer' }} onClick={() => launchLink('https://twitter.com/onefitnet_za')}>
                                        <div className="row align-items-center">
                                            <div className="col-4 text-end">
                                                <img src="/media/assets/icons/twitter-x-symbol-white.svg"
                                                    style={{ height: '40px', width: '40px' }} alt="Twitter - X logo" />
                                            </div>
                                            <div className="col text-center" style={{ color: 'var(--primary-color)' }}>
                                                |
                                            </div>
                                            <div className="col text-start">
                                                @onefitnet_za
                                            </div>
                                        </div>
                                    </li>
                                    <li className="list-group-item bg-transparent border-0 social-link-icon-fb my-2 shadow"
                                        style={{ cursor: 'pointer' }} onClick={() => launchLink('https://facebook.com/OnefitNetwork')}>
                                        <div className="row align-items-center">
                                            <div className="col-4 text-end">
                                                <i className="fab fa-facebook" style={{ fontSize: '40px' }}
                                                    aria-hidden="true"></i>
                                            </div>
                                            <div className="col text-center" style={{ color: 'var(--primary-color)' }}>
                                                |
                                            </div>
                                            <div className="col text-start">
                                                /OnefitNetwork
                                            </div>
                                        </div>
                                    </li>
                                    <li className="list-group-item bg-transparent border-0 social-link-icon-yt my-2 shadow"
                                        style={{ cursor: 'pointer' }} onClick={() => launchLink('https://youtube.com')}>
                                        <div className="row align-items-center">
                                            <div className="col-4 text-end">
                                                <i className="fab fa-youtube" style={{ fontSize: '40px' }}
                                                    aria-hidden="true"></i>
                                            </div>
                                            <div className="col text-center" style={{ color: 'var(--primary-color)' }}>
                                                |
                                            </div>
                                            <div className="col text-start">
                                                OnefitNet.TV
                                            </div>
                                        </div>
                                    </li>
                                </ul>

                                <span className="material-icons material-icons-outlined mt-4"
                                    style={{ color: '#fff' }}>error_outline</span>
                                <h5 className="fs-1 h4" style={{ color: 'var(--primary-color)' }}>Important</h5>
                                <hr className="text-white" />
                                <ul className="list-group bg-transparent comfortaa-font">
                                    <li className="list-group-item bg-transparent border-0 general-dark-link-item my-2 shadow p-4"
                                        style={{ cursor: 'pointer' }} onClick={() => launchLink('#')}>
                                        Our COVID-19 Responsibility
                                    </li>
                                    <li className="list-group-item bg-transparent border-0 general-dark-link-item my-2 shadow p-4"
                                        style={{ cursor: 'pointer' }} onClick={() => launchLink('#')}>
                                        Privacy Policy
                                    </li>
                                    <li className="list-group-item bg-transparent border-0 general-dark-link-item my-2 shadow p-4"
                                        style={{ cursor: 'pointer' }} onClick={() => launchLink('#')}>
                                        Terms of use
                                    </li>
                                    <li className="list-group-item bg-transparent border-0 general-dark-link-item my-2 shadow p-4"
                                        style={{ cursor: 'pointer' }} onClick={() => launchLink('#')}>
                                        Refund Policy
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div className="col-lg mb-4">
                            <div className="content-panel-border-style p-4 h-100"
                                style={{ paddingBottom: '40px', borderRadius: '25px', backgroundColor: 'var(--secondary-color)' }}>
                                <span className="material-icons material-icons-outlined"
                                    style={{ color: '#fff' }}>touch_app</span>
                                <h5 className="fs-1 h4" style={{ color: 'var(--primary-color)' }}>Navigation</h5>
                                <hr className="text-white" />
                                <ul className="list-group justify-content-end flex-grow-1 pe-3 comfortaa-font fs-3">
                                    <li className="my-2 shadow general-dark-link-item d-grid gap-2"
                                        style={{ borderRadius: '25px' }}>
                                        <button className="nav-link onefit-buttons-style-dark p-4 text-center border-0 w-100"
                                            onClick={() => launchLink('#')}>Home</button>
                                    </li>
                                    <li className="my-2 shadow general-dark-link-item d-grid gap-2"
                                        style={{ borderRadius: '25px' }}>
                                        <button className="nav-link onefit-buttons-style-dark p-4 text-center border-0 w-100"
                                            onClick={() => launchLink('#')}>Services</button>
                                    </li>
                                    {/* More links would go here */}
                                    <li className="my-2 shadow general-dark-link-item d-grid gap-2"
                                        style={{ borderRadius: '25px' }}>
                                        <a className="nav-link onefit-buttons-style-dark p-4 text-center w-100"
                                            href="/register" style={{ borderBottom: '0' }}>Account Registration</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div className="container-fluid px-4 align-items-center">
                <button className="navbar-toggler shadow onefit-buttons-style-dark p-3" type="button"
                    data-bs-toggle="collapse" data-bs-target="#navbarToggleExternalContent"
                    aria-controls="navbarToggleExternalContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <div className="d-grid gap-2">
                        <span className="material-icons material-icons-round" style={{ fontSize: '40px' }}>
                            widgets
                        </span>
                        <span style={{ fontSize: '10px' }}>More stuff...</span>
                    </div>

                </button>

                <p className="text-white align-end text-center comfortaa-font py-4 m-0">
                    <span style={{ fontSize: '10px' }}>
                        <span>Crafted by AdaptivConcept&trade; FL &copy; 2022. All rights reserved.</span> |
                    </span>
                    <a href="https://www.adaptivconcept.co.za/" target="_blank" className="comfortaa-font"
                        style={{ color: 'var(--primary-color)' }}>Support</a>
                </p>
            </div>
        </div>
    );
};

export default Footer;
