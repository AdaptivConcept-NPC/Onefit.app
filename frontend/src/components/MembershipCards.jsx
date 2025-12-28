import React from 'react';

const MembershipCards = () => {
    return (
        <div className="card-groupz grid-container">
            <div className="card grid-tile shadow border-5 border-top border-bottom"
                style={{ borderColor: 'var(--primary-color)!important', backgroundColor: 'var(--secondary-color) !important', overflow: 'hidden' }}>
                <img src="/media/assets/OnefitNet Profile Pic Redone.png" className="card-img-top"
                    alt="Pro Starter" />
                <div className="card-body">
                    <h5 className="card-title">Pro.Starter Training (Basic) - 3 Months</h5>
                    <p className="card-text">The Indi.Starter account offers Trainees access to Curated
                        Premium Fitness
                        Programs from Level-1 to Level-3 of our
                        Catalogue as well as access to Personal Trainer Support services to make
                        transitioning into Fitness
                        Process much easier.</p>
                </div>
                <div className="card-footer d-grid">
                    <button
                        className="onefit-buttons-style-dark p-4 text-center comfortaa-font fs-5 fw-bold">
                        R1800 (3 Months)
                    </button>
                </div>
            </div>
            <div className="card grid-tile shadow border-5 border-top border-bottom"
                style={{ borderColor: 'var(--primary-color)!important', backgroundColor: 'var(--secondary-color) !important', overflow: 'hidden' }}>
                <img src="/media/assets/OnefitNet Profile Pic Redone.png" className="card-img-top"
                    alt="Pro Athlete" />
                <div className="card-body">
                    <h5 className="card-title">Pro.Athlete Training (Pro) - 12 Months</h5>
                    <p className="card-text">This card has supporting text below as a natural lead-in to
                        additional content.
                    </p>
                </div>
                <div className="card-footer d-grid">
                    <button
                        className="onefit-buttons-style-dark p-4 text-center comfortaa-font fs-5 fw-bold">
                        R5200 (12 Months)
                    </button>
                </div>
            </div>
            <div className="card wide-grid-tile grid-tile shadow border-5 border-top border-bottom"
                style={{ borderColor: 'var(--primary-color)!important', backgroundColor: 'var(--secondary-color) !important', overflow: 'hidden' }}>
                <img src="/media/assets/OnefitNet Profile Pic Redone.png" className="card-img-top"
                    alt="Teams Pro" />
                <div className="card-body">
                    <h5 className="card-title">Teams.Pro Training (Pro) - Contact Sales</h5>
                    <p className="card-text">This is a wider card with supporting text below as a natural
                        lead-in to
                        additional
                        content.
                        This card has even longer content than the first to show that equal height
                        action.</p>
                </div>
                <div className="card-footer d-grid">
                    <button
                        className="onefit-buttons-style-dark p-4 text-center comfortaa-font fs-5 fw-bold">
                        Contact Sales
                    </button>
                </div>
            </div>
        </div>
    );
};

export default MembershipCards;
