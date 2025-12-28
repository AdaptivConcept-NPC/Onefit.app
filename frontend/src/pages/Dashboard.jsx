import React from 'react';
import DashboardNavbar from '../components/DashboardNavbar';
import DigitalClock from '../components/DigitalClock';
import FitnessProgressBar from '../components/FitnessProgressBar';

const Dashboard = () => {
    const userName = "User"; // Placeholder

    return (
        <div className="h-100 no-scroller" style={{ maxHeight: '100vh !important', overflowY: 'auto' }}>

            {/* Placeholder for header/cart that was in app/index.php lines 1000ish, 
            omitting for now to focus on Main Content Area structure first as requested. 
            Will add Header/Cart later. 
        */}

            {/* Main Content */}
            <main id="main-content-container" className="container" style={{ paddingBottom: '50px' }}>

                <DashboardNavbar />

                {/* Tab Content */}
                <div className="container-xlg">
                    <div className="d-grid justify-content-center pb-2">
                        <button className="onefit-buttons-style-light p-4 d-none" id="toggle-tab-container" type="button"
                            data-bs-toggle="collapse" data-bs-target="#tab-container" aria-expanded="true"
                            aria-controls="tab-container">
                            Show/Hide Tabs
                        </button>
                    </div>

                    <div className="tab-container collapse show" id="tab-container">
                        <div id="TabHome" className="shadow w3-container w3-animate-right content-tab p-4 app-tab"
                            style={{ display: 'block' }}>

                            <div className="p-4 my-4 d-grid justify-content-center text-center down-top-grad-dark border-5 border-end border-start"
                                style={{ borderRadius: '25px', borderColor: 'var(--accent-color) !important' }}>
                                <h5 className="mt-4 fs-1 text-center align-middle">
                                    <span className="material-icons material-icons-outlined align-middle"
                                        style={{ color: 'var(--secondary-color) !important', fontSize: '40px' }}>dashboard</span>
                                    <span className="align-middle">Dashboard</span>
                                </h5>
                            </div>

                            <div className="top-down-grad-dark rounded-5 mt-4 p-4 border-top border-5"
                                style={{ borderColor: 'var(--accent-color)!important' }}>
                                <h5 className="text-center fs-1" style={{ color: 'var(--text-color)' }}>Hi {userName}.</h5>
                                <p className="my-4 text-center fs-5" style={{ color: 'var(--text-color)' }}>Welcome to the
                                    Dashboard Page. Here, you can find
                                    various feeds from the activities we will be doing in the OnefitNet Community.</p>

                                <hr className="text-white" />

                                <div className="variable-grid-container">
                                    <div className="full-wide-grid-tile down-top-grad-dark p-4 shadow" style={{ borderRadius: '25px' }}>

                                        <FitnessProgressBar />

                                        <hr className="text-white" />

                                        <h5 className="align-middle text-center"><span
                                            className="material-icons material-icons-outlined align-middle">today</span><br />
                                            Today<br /> <span style={{ color: 'var(--primary-color)' }}>[</span>
                                            Date <span style={{ color: 'var(--primary-color)' }}>]</span>
                                        </h5>

                                        <DigitalClock />

                                        <div className="mt-4" id="dashboard-activity-lineup-container">
                                            <div className="p-4 text-center down-top-grad-dark border-5 border-end border-start"
                                                style={{ borderRadius: '25px', borderColor: 'var(--accent-color) !important', marginTop: '60px !important' }}>
                                                <h4 className="d-grid p-4 text-center border-5 border-top border-bottom"
                                                    style={{ backgroundColor: 'var(--secondary-color)', color: 'var(--text-color)', borderColor: 'var(--accent-color) !important', borderRadius: '15px' }}>
                                                    <span className="material-icons material-icons-round align-middle"
                                                        style={{ color: 'var(--primary-color) !important' }}>timeline</span>
                                                    <span className="p-4 align-middle">Activities lined up.</span>
                                                </h4>

                                                <div id="week-activities-list-container">
                                                    <div className="grid-container">
                                                        <div className="grid-tile down-top-grad-dark p-4 shadow">
                                                            <p className="my-4 fs-5 fw-bold comfortaa-font" style={{ cursor: 'pointer' }}>
                                                                No activities lined up. Go to
                                                                the <span style={{ color: 'var(--primary-color)' }}>.Studio</span> to
                                                                get active.
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {/* Content Card - Loading Spinner Placeholder */}
                                    <div className="grid-tile down-top-grad-dark p-4 shadow" style={{ borderRadius: '25px', marginTop: '20px' }}>
                                        <h4>News, Resources, Blog and Ads Feed</h4>
                                        <p style={{ color: 'var(--primary-color)' }}>Stay tuned for helpful resources...</p>
                                        <div className="text-center">
                                            <div className="spinner-border text-light" role="status"
                                                style={{ width: '5rem', height: '5rem' }}>
                                                <span className="visually-hidden">Loading...</span>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    );
};

export default Dashboard;
