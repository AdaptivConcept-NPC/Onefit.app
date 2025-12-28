
import React, { useEffect } from 'react';

const HomeContent = () => {

    useEffect(() => {
        // Load Twitter Widget Script
        const script = document.createElement("script");
        script.src = "https://platform.twitter.com/widgets.js";
        script.async = true;
        script.charset = "utf-8";
        document.body.appendChild(script);

        return () => {
            document.body.removeChild(script);
        };
    }, []);

    const playVideo = () => {
        console.log("Play video clicked");
        // Logic to play video or open modal
    };

    // Helper to launch links
    const launchLink = (url) => {
        window.open(url, '_blank');
    };

    return (
        <div className="row align-items-start text-white py-4" style={{ backgroundColor: 'rgba(52, 52, 52, 0)' }}>
            <div className="col-lg py-4" style={{ overflowY: 'auto' }}>
                <div className="content-panel-border-style p-4 tunnel-bg text-center"
                    style={{ borderRadius: '25px', backgroundColor: 'rgba(52, 52, 52, 0.8)', height: '80vh' }}>
                    <div className="my-2 pt-4 site-description text-center">
                        <h1 className="text-center">Join the One<span
                            style={{ color: 'var(--primary-color)' }}>fit</span><span
                                style={{ fontSize: '10px' }}>&trade;</span> Community.</h1>
                        <p className="mt-2 p-4 comfortaa-font text-center">OnefitNet<span
                            style={{ color: 'rgb(249, 158, 0)' }}>&trade;</span>&nbsp;(One-On-One Fitness Network) is
                            your community-centric destination for fitness, wellness, and lifestyle enhancement. Our
                            mission is to guide individuals of diverse backgrounds toward a heightened state of
                            well-being. Through a blend of inspirational content, expert guidance, and a thriving
                            community, we facilitate connections between trainers and trainees while fostering
                            fitness
                            groups across various realms of physical activity and athleticism. Let us be your
                            partner in
                            achieving your fitness aspirations, making new connections, and gaining empowering
                            knowledge. Sign up today to unlock a personalized journey featuring tailored training
                            and
                            nutrition plans crafted by professional trainers and dieticians, coupled with valuable
                            insights from health professionals.</p>
                        <p className="mt-2 p-4 comfortaa-font">
                            One-On-One Fitness Network. &copy; 2024 Developed by AdaptivConcept FL in collaboration with
                            LMM 1-ON-1 Trainer. All rights reserved.
                        </p>
                    </div>
                    <img src="/media/assets/OnefitNet Profile Pic Redone.png" className="img-fluid my-4 shadow"
                        alt="one fitness" style={{ maxHeight: '50vh', borderRadius: '25px', filter: 'invert(0)' }} />
                    <p className="my-4 text-center comfortaa-font" style={{ fontSize: '10px' }}>Crafted by AdaptivConcept&trade;
                        FL,
                        <br />in Partneship
                        with One-On-One Fitness Network | &copy; 2021. All rights reserved.
                    </p>
                    <hr className="text-white" />
                </div>
            </div>
            <div className="col-lg py-4 text-center" style={{ overflowY: 'auto', overflowX: 'hidden' }}>

                <div className="content-panel-border-style p-4 tunnel-bg -white shadow"
                    style={{ borderRadius: '25px', backgroundColor: 'rgba(52, 52, 52, 0.8)', height: '80vh' }}>
                    <h2 className="text-center mt-4" style={{ color: 'var(--text-color)' }}>Social.</h2>
                    <hr className="bg-warning" />

                    <h5 className="mt-4 text-center"><img src="/media/assets/icons/twitter-x-symbol-white.svg"
                        style={{ height: '40px', width: '40px', filter: 'invert(0)' }} alt="Twitter - X logo" /> Feed
                    </h5>

                    <div className="pb-4 no-scroller d-grid"
                        style={{ borderRadius: '25px', overflowY: 'scroll', height: '50vh' }}>
                        <a className="twitter-timeline" data-height="800" data-theme="dark" href="https://twitter.com/OnefitNet?ref_src=twsrc%5Etfw">Tweets by OnefitNet</a>
                        <div className="d-flex justify-content-center">
                            <div className="spinner-border grow text-light my-4" style={{ width: '3rem', height: '3rem' }}
                                role="status">
                                <span className="visually-hidden">Loading...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div className="col-md py-4 text-center" style={{ overflowY: 'auto', overflowX: 'auto' }}>
                <div className="content-panel-border-style p-4 tunnel-bg -white shadow"
                    style={{ borderRadius: '25px', backgroundColor: 'rgba(52, 52, 52, 0.8)', height: '80vh' }}>
                    <h2 className="text-center mt-4" style={{ color: 'var(--text-color)' }}>Updates.</h2>
                    <hr className="bg-warning" />
                    <div className="no-scroller shadow top-down-grad-tahiti"
                        style={{ borderRadius: '25px', background: 'var(--secondary-color)' }}>
                        <div className="p-0">
                            <div className="text-center py-4 top-down-grad-tahiti" style={{ borderRadius: '25px 25px 0 0' }}>
                                <img src="/media/assets/One-Symbol-Logo-White.svg" alt="logo" className="img-fluid p-4"
                                    style={{ maxWidth: '150px', borderRadius: '25px', filter: 'invert(0)' }} />
                            </div>

                            {/* Onefit.TV Horizontal Content Stream */}
                            <div className="mb-4" id="onefittv-footer-h-content-stream">
                                <div className="content-panel-border-stylez p-4 shadow border-5 border-start border-end text-white"
                                    style={{ paddingBottom: '40px', borderRadius: '25px', backgroundColor: 'var(--secondary-color)', borderColor: 'var(--primary-color)' }}>

                                    <h5 className="fs-1 h4 aligh-middle d-grid text-center"
                                        style={{ color: 'var(--primary-color)' }}>
                                        <span className="material-icons material-icons-outlined" style={{ color: '#fff' }}>
                                            tv
                                        </span>
                                        <span>OnefitNet.TV</span>
                                    </h5>
                                    <hr className="text-white" />

                                    <p className="my-4 text-center" style={{ fontSize: '10px' }}>Latest Training Programs |
                                        <span className="comfortaa-font"
                                            style={{ color: 'var(--primary-color)' }}>OnefitNet.TV</span>
                                    </p>

                                    <div className="d-none d-lg-block w3-animate-bottom">
                                        <div className="video-card-container">
                                            <img src="/media/assets/YouTube Thumbnail 1280x720 px.gif"
                                                alt="latest video" className="img-fluid shadow m-0"
                                                style={{ borderRadius: '15px', filter: 'invert(0)' }} />
                                            <button
                                                className="onefit-buttons-style-light shadow-lg play-btn p-2 aligh-middle"
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
                                                    style={{ backgroundColor: 'var(--secondary-color)', color: 'var(--primary-color)', borderColor: 'var(--primary-color)' }}>
                                                    <span className="align-middle"
                                                        style={{ fontSize: '10px' }}>+3</span>
                                                    <span className="visually-hidden">Latest Video Count</span>
                                                </span>
                                            </button>
                                        </div>
                                    </div>

                                    {/* Mobile Horizontal Scroll - Placeholder for brevity, similar to Footer logic */}
                                    <div className="horizontal-scroll d-lg-none w3-animate-bottom">
                                        <div className="horizontal-scroll-card p-4">
                                            <img src="/media/assets/YouTube Thumbnail 1280x720 px.gif"
                                                alt="placeholder" className="img-fluid mb-4"
                                                style={{ borderRadius: '25px', filter: 'invert(0)' }} />
                                            <hr className="text-white" style={{ height: '5px' }} />

                                            <div className="row my-2 align-items-center">
                                                <div className="col-sm-2 text-center">
                                                    <img src="/media/assets/icons/icons8-sports-mode-50.png"
                                                        className="img-fluid p-4" alt="placeholder"
                                                        style={{ borderRadius: '5px', backgroundColor: 'var(--primary-color)', filter: 'invert(0)' }} />
                                                </div>
                                                <div className="col-sm">
                                                    <h5>Ep.1 - Best Resistence Exercises | Head Trainer.: Lehlohonolo Matsoso</h5>
                                                    <p className="align-middle comfortaa-font"><span className="material-icons material-icons-round" style={{ fontSize: '20px' }}>timer</span> Duration: 1 hour</p>
                                                    <button className="onefit-buttons-style-dark shadow p-4 mt-4 comfortaa-font">
                                                        Subscribe on <span className="comfortaa-font" style={{ color: 'var(--primary-color)' }}>OnefitNet.TV</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div className="row mt-4 text-center align-items-startz" style={{ overflowY: 'auto' }}>
                                <div className="col-lg mb-4">
                                    <div className="content-panel-border-style p-4 h-100"
                                        style={{ paddingBottom: '40px', borderRadius: '25px', backgroundColor: 'var(--secondary-color)' }}>
                                        <span className="material-icons material-icons-outlined" style={{ color: '#fff' }}>tag</span>
                                        <h5 className="fs-1 h4" style={{ color: 'var(--primary-color)' }}>Social</h5>
                                        <hr className="text-white" />
                                        <ul className="list-group bg-transparent comfortaa-font">
                                            <li className="list-group-item bg-transparent border-0 social-link-icon-insta my-2 shadow" style={{ cursor: 'pointer' }} onClick={() => launchLink('https://www.instagram.com/onefit_net')}>
                                                <div className="row align-items-center">
                                                    <div className="col-4 text-end">
                                                        <i className="fab fa-instagram" style={{ fontSize: '40px', color: 'var(--white)' }} aria-hidden="true"></i>
                                                    </div>
                                                    <div className="col text-center" style={{ color: 'var(--primary-color)' }}>|</div>
                                                    <div className="col text-start text-white">@onefit_net</div>
                                                </div>
                                            </li>
                                            <li className="list-group-item bg-transparent border-0 social-link-icon-twitter my-2 shadow" style={{ cursor: 'pointer' }} onClick={() => launchLink('https://twitter.com/onefitnet_za')}>
                                                <div className="row align-items-center">
                                                    <div className="col-4 text-end">
                                                        <img src="/media/assets/icons/twitter-x-symbol-white.svg" style={{ height: '40px', width: '40px', filter: 'invert(0)' }} alt="Twitter - X logo" />
                                                    </div>
                                                    <div className="col text-center" style={{ color: 'var(--primary-color)' }}>|</div>
                                                    <div className="col text-start text-white">@onefitnet_za</div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default HomeContent;
