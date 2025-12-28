import React from 'react';

const RegistrationForm = () => {
    return (
        <form id="community-registration-form" name="community-registration-form"
            className="container text-center comfortaa-font fs-5 needs-validation" method="post"
            action="#" // Placeholder action
            autoComplete="off">
            <div className="output-container my-2" id="output-container">
                {/* Output messages would go here */}
            </div>

            <div id="emailHelp" className="form-text text-center d-grid gap-2 fw-bold my-4"
                style={{ color: '#fff' }}>
                <p>We have a responsibility to
                    keep your keep your Identity &amp; Privacy safe!
                </p>
                <span className="material-icons material-icons-round align-middle"
                    style={{ fontSize: '28px!important' }}>
                    policy
                </span>
                <a href="#" className="fw-bold mx-2" style={{ color: 'var(--primary-color)' }}>Feel free to
                    read
                    our Privacy
                    Policy.</a>
            </div>

            <hr className="mx-4 bg-white" />

            <div className="form-group mb-4 text-start">
                <label className="fw-bold poppins-font" htmlFor="reg-name"
                    style={{ color: 'var(--primary-color)' }}>First
                    Name</label>
                <input className="form-control-text-input p-4" type="text" name="reg-name" id="reg-name"
                    placeholder="Required." required />
            </div>

            <div className="form-group mb-4 text-start">
                <label className="fw-bold poppins-font" htmlFor="reg-surname"
                    style={{ color: 'var(--primary-color)' }}>Last
                    Name</label>
                <input className="form-control-text-input p-4" type="text" name="reg-surname" id="reg-surname"
                    placeholder="Required." required />
            </div>

            <div className="form-group mb-4 text-start">
                <label className="fw-bold poppins-font" htmlFor="reg-email"
                    style={{ color: 'var(--primary-color)' }}>Email
                    address</label>
                <input className="form-control-text-input p-4" type="email" name="reg-email" id="reg-email"
                    placeholder="Required." required />
            </div>

            <div className="form-group mb-4 text-start">
                <label className="fw-bold poppins-font" htmlFor="reg-contact"
                    style={{ color: 'var(--primary-color)' }}>Phone
                    number</label>
                <input className="form-control-text-input p-4" type="tel" defaultValue="+27" name="reg-contact"
                    id="reg-contact" placeholder="Required." required />
                <p className="text-center">
                    <span className="material-icons material-icons-round align-middle"
                        style={{ fontSize: '20px!important', color: 'var(--primary-color)' }}>
                        crisis_alert
                    </span>
                    <small className="align-middle">please use this format: <strong>+27
                        714567890</strong></small>
                </p>
            </div>

            <div className="form-group mb-4 text-start">
                <label className="fw-bold poppins-font" htmlFor="reg-dob" style={{ color: 'var(--primary-color)' }}>Date
                    of
                    birth</label>
                <input className="form-control-text-input p-4" type="date" name="reg-dob" id="reg-dob"
                    placeholder="Required." required />
            </div>

            <div className="form-group mb-4 text-start">
                <label className="fw-bold poppins-font" htmlFor="reg-gender"
                    style={{ color: 'var(--primary-color)' }}>Gender</label>
                <select className="custom-select form-control-select-input p-4" name="reg-gender"
                    id="reg-gender" placeholder="Required." required>
                    <option value="Female">Female</option>
                    <option value="Male">Male</option>
                </select>
            </div>

            <div className="form-group mb-4 text-start">
                <label className="fw-bold poppins-font" htmlFor="reg-race" style={{ color: 'var(--primary-color)' }}>Race
                    /
                    Ethnicity</label>
                <select className="custom-select form-control-select-input p-4" name="reg-race" id="reg-race"
                    placeholder="Required." required>
                    <option value="black">Black</option>
                    <option value="white">White</option>
                    <option value="coloured">Coloured</option>
                    <option value="asian">Asian</option>
                </select>
            </div>
            <div className="form-group mb-4 text-start">
                <label className="fw-bold poppins-font" htmlFor="reg-nationality"
                    style={{ color: 'var(--primary-color)' }}>Nationality</label>
                <select className="custom-select form-control-select-input p-4" name="reg-nationality"
                    id="reg-nationality" placeholder="Required." required>
                    <option value='South Africa'>South Africa</option>
                    {/* Simplified list for brevity - in real app, we would include the full list */}
                    <option value='United States'>United States</option>
                    <option value='United Kingdom'>United Kingdom</option>
                    <option value='Zimbabwe'>Zimbabwe</option>
                </select>
            </div>

            <div className="form-group mb-4 text-start">
                <label className="fw-bold poppins-font" htmlFor="reg-password"
                    style={{ color: 'var(--primary-color)' }}>Create your password</label>
                <input className="form-control-text-input p-4" type="password" name="reg-password"
                    id="reg-password" placeholder="Create your new password." required />
            </div>

            <div className="form-group mb-4 text-start">
                <label className="fw-bold poppins-font" htmlFor="reg-confirmpassword"
                    style={{ color: 'var(--primary-color)' }}>Repeat your password</label>
                <input className="form-control-text-input p-4" type="password" name="reg-confirmpassword"
                    id="reg-confirmpassword" placeholder="Let's check if you have it down." required />
            </div>

            <div className="text-center d-gridz gap-2 py-2 down-top-grad-tahiti"
                style={{ borderRadius: '0 0 25px 25px' }}>
                <button type="submit" className="my-4 p-5 onefit-buttons-style-dark btn-lg shadow-lg"
                    id="signup-btn">
                    <span className="material-icons material-icons-round align-middle"
                        style={{ color: 'var(--primary-color)' }}>
                        how_to_reg
                    </span>
                    <span className="align-middle"> Create account.</span>
                </button>
            </div>
        </form>
    );
};

export default RegistrationForm;
