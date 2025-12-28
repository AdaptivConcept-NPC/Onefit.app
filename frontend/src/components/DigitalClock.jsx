import React, { useEffect, useState } from 'react';

const DigitalClock = () => {
    const [time, setTime] = useState(new Date());

    useEffect(() => {
        const timer = setInterval(() => {
            setTime(new Date());
        }, 1000);
        return () => clearInterval(timer);
    }, []);

    const days = ['SUN', 'MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT'];
    const currentDay = days[time.getDay()];
    const hours = time.getHours();
    const minutes = time.getMinutes().toString().padStart(2, '0');
    const seconds = time.getSeconds().toString().padStart(2, '0');
    const ampm = hours >= 12 ? 'PM' : 'AM';
    const displayHours = (hours % 12 || 12).toString().padStart(2, '0');

    return (
        <div id="dashboard-tab-clock">
            <div id="clock" className="dark my-4 shadow">
                <div className="display no-scroller">
                    <div className="weekdays">
                        {days.map(day => (
                            <span key={day} className={day === currentDay ? 'active' : ''} style={{ marginRight: '5px', opacity: day === currentDay ? 1 : 0.4 }}>
                                {day}
                            </span>
                        ))}
                    </div>
                    <div className="ampm">{ampm}</div>
                    <div className="alarm"></div>
                    <div className="digits">
                        {displayHours}:{minutes}:{seconds}
                    </div>
                </div>
            </div>
        </div>
    );
};

export default DigitalClock;
