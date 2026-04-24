import React from 'react';

const TabNavModal = ({ onTabChange }) => {
    const tabs = [
        { id: 'TabHome', label: 'Dashboard', icon: 'dashboard' },
        { id: 'TabProfile', label: 'Profile', icon: 'account_circle' },
        { id: 'TabDiscovery', label: 'Discovery', icon: 'travel_explore' },
        { id: 'TabStudio', label: 'Onefit.Studio', icon: 'play_circle_outline' },
        { id: 'TabStore', label: 'Onefit.Store', icon: 'storefront' },
        { id: 'TabData', label: 'Fitness Insights', icon: 'insights' },
        { id: 'TabTraining', label: 'Training', icon: 'sports' },
        { id: 'TabAchievements', label: 'Achievements', icon: 'emoji_events', locked: true },
    ];

    return (
        <div className="modal fade" id="tabNavModal" data-bs-backdrop="static" data-bs-keyboard="false" tabIndex="-1"
            aria-labelledby="tabNavModalLabel" aria-hidden="true">
            <div className="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable modal-fullscreen-lg-down">
                <div className="modal-content feature-tab-nav-content" style={{ backgroundColor: 'var(--secondary-color)', borderRadius: '25px' }}>
                    <div className="modal-header border-0">
                        <h5 className="modal-title fs-1 text-white" id="tabNavModalLabel">
                            <span style={{ color: 'var(--primary-color)' }}>app</span>.nav
                        </h5>
                        <button type="button" className="onefit-buttons-style-danger p-2 rounded-pill"
                            data-bs-dismiss="modal" aria-label="Close" style={{ width: '40px', height: '40px', display: 'flex', alignItems: 'center', justifyContent: 'center' }}>
                            <span className="material-icons material-icons-round"> close </span>
                        </button>
                    </div>
                    <div className="modal-body border-0 down-top-grad-tahiti py-4 px-5" style={{ overflowX: 'hidden' }}>
                        <div className="variable-grid-container text-center">
                            {tabs.map((tab) => (
                                <div key={tab.id} className="d-grid grid-tile modal-grid-tile-transform">
                                    <button 
                                        className="bg-transparent onefit-buttons-style-dark-modal p-4 shadow-lg app-nav-btn"
                                        data-bs-dismiss="modal" 
                                        onClick={() => onTabChange(tab.id)}
                                        disabled={tab.locked}
                                    >
                                        <div className="d-grid gap-2">
                                            <span className="material-icons material-icons-round" style={{ color: 'var(--text-color)', fontSize: '40px' }}>
                                                {tab.icon}
                                            </span>
                                            <div className="d-inline text-white">
                                                <span style={{ color: 'var(--text-color) !important' }} className="fs-5 align-middle">
                                                    {tab.label}
                                                </span>
                                                {tab.locked && (
                                                    <span className="material-icons material-icons-round text-muted ms-2" style={{ fontSize: '12px' }}>
                                                        lock
                                                    </span>
                                                )}
                                            </div>
                                        </div>
                                    </button>
                                </div>
                            ))}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default TabNavModal;
