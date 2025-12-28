import React from 'react';
import { Link } from 'react-router-dom';

const DashboardNavbar = () => {
    return (
        <nav id="main-navbar" className="navbar w-100 mb-4 p-4 down-top-grad-dark"
            style={{ borderRadius: '25px', maxHeight: '100vh !important', borderTop: 'var(--secondary-color) solid 0px' }}>

            {/* App Function Buttons Container */}
            <div className="container d-flex gap-4 align-items-center justify-content-between w3-animate-top">

                {/* Notifications Button */}
                <button id="app-notifications-btn"
                    style={{ borderColor: 'var(--primary-color)!important', minWidth: '85.69px' }}
                    className="onefit-buttons-style-dark p-3 shadow hide-left-side-panels d-none d-sm-block border-bottom border-5 flex-fill"
                    type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNotifications"
                    aria-controls="offcanvasNotifications">
                    <div className="d-grid gap-2 justify-content-center">
                        <span className="material-icons material-icons-round" style={{ fontSize: '24px !important' }}>
                            notifications </span>
                        <span className="d-none d-lg-block text-truncate"
                            style={{ fontSize: '10px', maxWidth: '55.69px' }}>Notifications</span>
                    </div>
                </button>

                {/* Preferences/Settings Button */}
                <button type="button" id="apps-tray-open-btn"
                    style={{ borderColor: 'var(--primary-color)!important', minWidth: '85.69px' }}
                    className="onefit-buttons-style-dark p-3 shadow comfortaa-font hide-side-panels border-bottom border-5 flex-fill"
                    data-bs-toggle="modal" data-bs-target="#tabNavModal">
                    <div className="d-grid gap-2 justify-content-center">
                        <span className="material-icons material-icons-round" style={{ fontSize: '24px !important' }}
                            id="apps-tray-open-btn-icon"> settings_accessibility </span>
                        <span className="d-none d-lg-block text-truncate" id="apps-tray-open-btn-text"
                            style={{ fontSize: '10px', maxWidth: '55.69px' }}>Preferences</span>
                    </div>
                </button>

                {/* Refresh Button */}
                <div className="d-grid gap-2">
                    <button id="main-app-refresh-btn" style={{ borderColor: 'var(--primary-color)!important' }}
                        className="onefit-buttons-style-dark p-4 shadow d-nonez d-lg-blockz border-start border-end border-5 flex-fill"
                        type="button" onClick={() => window.location.reload()}>
                        <div className="d-grid gap-2 text-center">
                            <div className="text-center">
                                <img src="/media/assets/One-Symbol-Logo-White.svg" alt="Onefit Logo"
                                    className="p-1 img-fluid my-pulse-animation-tahitiz"
                                    style={{ height: '50px', width: '50px', borderRadius: '15px', borderColor: 'var(--accent-color) !important', filter: 'invert(0)' }} />
                            </div>
                            <span className="d-none d-lg-block text-truncate">Refresh</span>
                        </div>
                    </button>
                </div>

                {/* Widgets Button */}
                <button id="open-widgets-panel-btn" type="button"
                    style={{ borderColor: 'var(--primary-color)!important', minWidth: '85.69px' }}
                    className="onefit-buttons-style-dark p-3 shadow comfortaa-font show-side-panels border-bottom border-5 flex-fill"
                    data-bs-toggle="collapse" data-bs-target="#widget-rows-container"
                    aria-controls="widget-rows-container">
                    <div className="d-grid gap-2 justify-content-center">
                        <span className="material-icons material-icons-round" style={{ fontSize: '24px !important' }}> interests
                        </span>
                        <span className="d-none d-lg-block text-truncate"
                            style={{ fontSize: '10px', maxWidth: '55.69px' }}>Widgets</span>
                    </div>
                </button>

                {/* Web.nav (Offcanvas Trigger) */}
                <button id="main-nav-ext-links-btn"
                    style={{ borderColor: 'var(--primary-color)!important', minWidth: '85.69px' }}
                    className="navbar-toggler shadow onefit-buttons-style-dark p-3 hide-right-side-panels d-none d-sm-block border-bottom border-5 flex-fill"
                    type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar"
                    aria-controls="offcanvasNavbar">
                    <div className="d-grid gap-2 justify-content-center">
                        <span className="material-icons material-icons-round align-middle"
                            style={{ fontSize: '28px !important' }}> public
                        </span>
                        <span className="d-none d-lg-block text-truncate"
                            style={{ fontSize: '10px', maxWidth: '55.69px' }}>Web.nav</span>
                    </div>
                </button>
            </div>

            {/* --- OFF CANVASES --- */}

            {/* Notifications Offcanvas */}
            <div className="offcanvas offcanvas-start offcanvas-menu-primary-style w-100"
                tabIndex="-1" id="offcanvasNotifications" aria-labelledby="offcanvasNotificationsLabel">
                <div className="offcanvas-header fs-1"
                    style={{ backgroundColor: 'var(--secondary-color)', color: 'var(--text-color)' }}>
                    <button id="app-notifications-close-btn" type="button"
                        className="onefit-buttons-style-light rounded-pill shadow p-2" data-bs-dismiss="offcanvas"
                        aria-label="Close">
                        <span className="material-icons material-icons-round align-middle"
                            style={{ fontSize: '20px!important' }}> close </span>
                    </button>
                    <h5 className="offcanvas-title text-center text-truncate fs-2" id="offcanvasNavbarLabel">
                        <span className="material-icons material-icons-round align-middle"
                            style={{ color: 'var(--primary-color)', cursor: 'pointer', fontSize: '40px!important' }}>
                            notifications
                        </span>
                        Alerts &amp; Notifications.
                    </h5>
                </div>
                <div className="offcanvas-body top-down-grad-dark">
                    <div className="row">
                        <div className="col-md">
                            <h5 className="fs-5 text-white poppins-font">Notifications.</h5>
                            <div id="communicationUserNotifications">
                                <p className="text-white">No new notifications.</p>
                            </div>
                            <hr className="text-white" />
                            <h5 className="fs-5 text-white poppins-font">Alerts. <span className="alert-count">0</span></h5>
                        </div>
                    </div>
                </div>
            </div>

            {/* Web.nav Offcanvas */}
            <div className="offcanvas offcanvas-end offcanvas-menu-primary-style w-100" tabIndex="-1"
                id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                <div className="no-scroller" id="offcanvas-menu">
                    <div className="offcanvas-header fs-1" style={{ color: 'var(--text-color)' }}>
                        <img src="/media/assets/One-Logo.svg" alt="" className="img-fluid logo-size-2"
                            style={{ maxWidth: '100px', filter: 'invert(0)' }} />
                        <h5 className="offcanvas-title text-center" id="offcanvasNavbarLabel">
                            <span className="material-icons material-icons-round align-middle"
                                style={{ color: 'var(--primary-color)', cursor: 'pointer', fontSize: '20px!important' }}>
                                public
                            </span>
                            Web.nav
                        </h5>
                        <button type="button" className="onefit-buttons-style-light rounded-pill shadow p-2"
                            data-bs-dismiss="offcanvas" aria-label="Close">
                            <span className="material-icons material-icons-round align-middle"
                                style={{ fontSize: '20px!important' }}> close </span>
                        </button>
                    </div>
                    <div className="offcanvas-body"
                        style={{ paddingBottom: '40px', overflowY: 'auto', overflowX: 'hidden', maxHeight: '86.9vh' }}>

                        <div className="row">
                            <div className="col-md">
                                <ul className="navbar-nav justify-content-end flex-grow-1 py-3 comfortaa-font fs-3 gap-4">
                                    <li className="nav-item text-center">
                                        <div className="d-grid mb-2">
                                            <p className="text-white comfortaa-font fs-4 mb-0 fw-bold"> Presented by </p>
                                            <p className="text-white audiowide-font mt-1 mb-0 fw-bold" style={{ fontSize: '8px !important' }}>
                                                <span style={{ color: 'var(--tahitigold)' }}>One</span>-On-<span style={{ color: 'var(--tahitigold)' }}>One</span> Fitness Network<sup style={{ color: 'var(--tahitigold)' }}>®</sup>
                                            </p>
                                        </div>
                                    </li>
                                    <li className="nav-item">
                                        <a className="nav-link p-4 py-5 text-center down-top-grad-tahiti"
                                            style={{ borderRadius: '25px !important', fontSize: '16px' }}
                                            href="https://onefitnet.co.za/" target="_blank" rel="noreferrer">One-On-One Fitness Network<span style={{ color: 'var(--primary-color)' }}>™</span></a>
                                    </li>
                                    <Link className="nav-item text-decoration-none" to="/">
                                        <button className="onefit-buttons-style-light rounded-pill p-4 text-center shadow fw-bold w-100"
                                            style={{ borderRadius: '25px!important' }}>
                                            <div className="align-items-center">
                                                <span className="material-icons material-icons-outlined align-middle"
                                                    style={{ color: 'var(--primary-color)', fontSize: '20px!important' }}>
                                                    logout
                                                </span>
                                                <span className="align-middle" style={{ fontSize: '20px!important' }}>
                                                    Logout / Landing
                                                </span>
                                            </div>
                                        </button>
                                    </Link>
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </nav>
    );
};

export default DashboardNavbar;
