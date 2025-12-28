import React from 'react';

const FitnessProgressBar = () => {
    return (
        <div id="fitness-progression-progress-bar-dashboard" className="bar-fpwidget">
            <h5 className="mt-4">
                <span className="material-icons material-icons-outlined align-middle"
                    style={{ color: 'var(--primary-color)' }}>data_exploration</span> <span
                        className="align-middle">Fitness Progression</span>
            </h5>
            <div className="progress mt-4" style={{ height: '4px' }}>
                <div className="progress-bar" role="progressbar" aria-label="Fitness Progress"
                    style={{ width: '25%', backgroundColor: 'var(--primary-color) !important', borderRight: 'var(--accent-color) 10px solid' }}
                    aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <div className="row mt-2" style={{ marginBottom: '60px' }}>
                <div className="col text-start comfortaa-font" style={{ fontSize: '12px' }}>
                    Current XP <strong>(112)</strong>
                </div>
                <div className="col text-end comfortaa-font" style={{ fontSize: '12px' }}>
                    Target XP <strong>(150)</strong>
                </div>
            </div>
        </div>
    );
};

export default FitnessProgressBar;
