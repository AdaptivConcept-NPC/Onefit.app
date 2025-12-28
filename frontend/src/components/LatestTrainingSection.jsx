
import React from 'react';

const LatestTrainingSection = () => {
    const playVideo = () => {
        console.log("Play video clicked");
        // Logic to play video or open modal
    };

    return (
        <div className="container-fluid m-0 p-4">
            <span className="material-icons material-icons-outlined"> tv </span>
            <p style={{ fontSize: '10px' }}>Latest Training Programs | <span className="comfortaa-font fs-5 align-middle"
                style={{ color: 'var(--primary-color)' }}>OnefitNet.TV</span></p>

            <div className="video-card-container border-white border border-5 bg-white">
                <img src="/media/assets/YouTube Thumbnail 1280x720 px.gif" alt="" className="img-fluid shadow"
                    style={{ filter: 'invert(0)' }} />
                <button className="onefit-buttons-style-light shadow play-btn p-3" onClick={playVideo}>
                    <span className="material-icons material-icons-round" style={{ fontSize: '40px' }}>
                        play_circle_outline
                    </span>
                </button>
            </div>
        </div>
    );
};

export default LatestTrainingSection;
