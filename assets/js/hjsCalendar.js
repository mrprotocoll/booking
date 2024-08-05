function hjsCalendar(availableDates = [], handleEvent) {
    // Set up the calendar HTML structure
    document.getElementById("hjsCalendar").innerHTML = `
        <div class="">
            <div class="justify-content-center d-md-flex">
                <div class="bg-white left">
                    <div class="bg-white calendar mx-auto pb-3 px-2">
                        <div class="d-flex align-items-center justify-content-between text-uppercase month py-4">
                            <div class="fw-bold text-primary ms-3" id="date"></div>
                            <div class="d-flex align-items-center justify-content-center gap-3">
                                <div class="d-flex align-items-center justify-content-center rounded-circle" id="prev">
                                    <i class="fa fa-angle-left"></i>
                                </div>
                                <div class="d-flex align-items-center justify-content-center rounded-circle" id="nxt">
                                    <i class="fa fa-angle-right"></i>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center justify-content-between text-uppercase fw-light h-100 mb-2 text-sm w-100 weekdays">
                            <div class="fw-bold">Sun</div>
                            <div class="fw-bold">Mon</div>
                            <div class="fw-bold">Tue</div>
                            <div class="fw-bold">Wed</div>
                            <div class="fw-bold">Thu</div>
                            <div class="fw-bold">Fri</div>
                            <div class="fw-bold">Sat</div>
                        </div>
                        <div class="d-flex justify-content-between w-100 flex-wrap" id="days"></div>
                    </div>
                </div>
                <div class="bg-white d-none px-3 right" id="rightContent">
                    <div class="fw-bold text-primary d-flex py-5" id="today-date">
                        <div id="event-day">Wednesday,</div>
                        <div id="event-date">19 April</div>
                    </div>
                    <div class="text-center" style="width: 254px;">
                        <div class="events me-4" id="meeting_daily_timings"></div>
                    </div>
                </div>
            </div>
        </div>`;

    // Get references to various elements
    let dateElement = document.getElementById("date"),
        daysElement = document.getElementById("days"),
        prevButton = document.getElementById("prev"),
        nextButton = document.getElementById("nxt"),
        rightContent = document.getElementById("rightContent"),
        activeEventTime = document.getElementById("activeEvent-time"),
        activeConfirmBtn = document.getElementById("activeConfirm-btn"),
        eventTimes = document.getElementsByClassName("event-time");

    let currentDate = new Date(),
        currentMonth = currentDate.getMonth(),
        currentYear = currentDate.getFullYear(),
        today = currentDate.getDate();

    currentDate.setMonth(currentDate.getMonth() + 1);
    let nextMonth = currentDate.getMonth();

    let months = [
        "January", "February", "March", "April", "May", "June",
        "July", "August", "September", "October", "November", "December"
    ];

    // Function to get the Sundays in a month
    function getSundays(year, month) {
        let sundays = [];
        let date = new Date(year, month, 1);
        while (date.getMonth() === month) {
            if (date.getDay() === 0) {
                sundays.push(date.getDate());
            }
            date.setDate(date.getDate() + 1);
        }
        return sundays;
    }

    let events = {};

    // Function to render the calendar
    function renderCalendar() {
        let firstDay = new Date(currentYear, currentMonth, 1),
            lastDay = new Date(currentYear, currentMonth + 1, 0),
            prevLastDay = new Date(currentYear, currentMonth, 0),
            prevLastDate = prevLastDay.getDate(),
            lastDate = lastDay.getDate(),
            firstDayIndex = firstDay.getDay(),
            lastDayIndex = 7 - lastDay.getDay() - 1;

        dateElement.innerHTML = months[currentMonth] + " " + currentYear;

        // Previous month days
        let daysHTML = "";
        let fullDate = "";
        for (let i = firstDayIndex; i > 0; i--) {
            daysHTML += `<div class='day prev-date'>${prevLastDate - i + 1}</div>`;
        }


        // Current month days
        for (let i = 1; i <= lastDate; i++) {
            let fullDate = `${currentYear}-${String(currentMonth + 1).padStart(2, '0')}-${String(i).padStart(2, '0')}`;
            let isAvailable = availableDates.includes(fullDate);

            if (i < new Date().getDate() && currentYear === new Date().getFullYear() && currentMonth === new Date().getMonth() || getSundays(currentYear, currentMonth).includes(i)) {
                daysHTML += `<div class='day tillCurrentDate'>${i}</div>`;
            } else if (i === new Date().getDate() && currentYear === new Date().getFullYear() && currentMonth === new Date().getMonth()) {
                daysHTML += `<div class='day today'>${i}</div>`;
            }
            // else if (currentMonth === new Date().getMonth() && currentYear === new Date().getFullYear() || currentMonth === nextMonth && currentYear === new Date().getFullYear()) {
            //     daysHTML += `<div class="day">${i}</div>`;
            // }
            else if(isAvailable){
                daysHTML += `<div class='day available'>${i}</div>`;
            } else {
                daysHTML += `<div class="day futureDays">${i}</div>`;
            }
        }

        // Next month days
        for (let i = 1; i <= lastDayIndex; i++) {
            daysHTML += `<div class='day nxt-date'>${i}</div>`;
        }
        daysElement.innerHTML = daysHTML;

        // Add click event listeners to days
        let dayElements = document.querySelectorAll(".day");
        let sundays = getSundays(currentYear, currentMonth);
        dayElements.forEach(dayElement => {
            dayElement.addEventListener("click", event => {
                var hours = [];
                if (sundays.indexOf(Number(dayElement.textContent)) !== -1) {
                    console.log("This is Sunday");
                } else {
                    dayElements.forEach(dayElement => {
                        dayElement.classList.remove("active");
                    });
                    // if (dayElement.textContent >= today && currentMonth === new Date().getMonth() || currentMonth === nextMonth && !sundays.includes(Number(dayElement.textContent))) {
                    if (dayElement.classList.contains('available')) {
                        rightContent.classList.remove("d-none");
                        updateEventDetails(event.target.innerHTML);
                        dayElement.classList.add("active");
                        let selectedDay = dayElement.innerHTML,
                            meetingTimingsElement = document.getElementById("meeting_daily_timings"),
                            meetingTimingsHTML = "",
                            disabled = "",
                            disabledClass = "";
                        const sDate = `${currentYear}-${String(currentMonth + 1).padStart(2, '0')}-${selectedDay.padStart(2, '0')}`;
                        $.ajax({
                            url: 'api/availabilities/getTime.php',
                            method: 'GET',
                            data: { date: sDate },
                            success: function(response) {
                                if (response.status === 'success') {
                                    if(hours.length < 1){
                                        hours = [9,10,11,12,13,14,15,16];
                                    }
                                    hours.forEach((hour) => {
                                        if (new Date(currentYear, currentMonth, selectedDay, hour, 0, 0, 0).getTime() < Date.now()) {
                                            disabled = "disabled";
                                            disabledClass = "btnDisable";
                                        } else {
                                            disabled = "";
                                            disabledClass = "";
                                        }
                                        let timeString = new Date(currentYear, currentMonth, selectedDay, hour, 0, 0, 0).toLocaleString("en-GB", {
                                            hour12: true,
                                            hour: "numeric",
                                            minute: "numeric"
                                        });
                                        if (events[new Date(currentYear, currentMonth, selectedDay, hour).toJSON()] > 2) {
                                            meetingTimingsHTML += `<div class="button-full" id="prepTime_${hour}">
                                                <button class="event-time meeting btnDisable" disabled>${hour === 12 ? "12:00 pm" : timeString}</button>
                                            </div>`;
                                        } else {
                                            meetingTimingsHTML += `<div class="button-full" id="prepTime_${hour}">
                                                <button onclick="meetTime('prepTime_${hour}')" class="event-time meeting ${disabledClass}" ${disabled}>${hour === 12 ? "12:00 pm" : timeString}</button>
                                                <button onclick="confirmMeeting('${new Date(currentYear, currentMonth, selectedDay, hour, 0, 0, 0).toJSON()}')" class="confirm-btn">Confirm</button>
                                            </div>`;
                                        }
                                    })

                                    meetingTimingsElement.innerHTML = meetingTimingsHTML;
                                } else {
                                    toastr.error('Failed to fetch time')
                                }
                            },
                            error: function() {
                                toastr.error('An error occurred while fetching time');
                            }
                        });
                    }
                }
            });
        });
    }

    renderCalendar();

    // Event listeners for navigating through months
    prevButton.addEventListener("click", () => {
        currentMonth--;
        if (currentMonth < 0) {
            currentMonth = 11;
            currentYear--;
        }
        renderCalendar();
    });

    nextButton.addEventListener("click", () => {
        currentMonth++;
        if (currentMonth > 11) {
            currentMonth = 0;
            currentYear++;
        }
        renderCalendar();
    });

    let previousActiveElement = null;

    this.meetTime = elementId => {
        let element = document.getElementById(elementId);
        if (previousActiveElement !== null) {
            previousActiveElement.children[0].classList.remove("activeEvent-time");
            previousActiveElement.children[1].classList.remove("activeConfirm-btn");
        }
        element.children[0].classList.add("activeEvent-time");
        element.children[1].classList.add("activeConfirm-btn");
        previousActiveElement = element;
    };

    let eventDayElement = document.getElementById("event-day"),
        eventDateElement = document.getElementById("event-date");

    this.confirmMeeting = eventJson => handleEvent(eventJson);

    // Function to update event details
    function updateEventDetails(day) {
        let eventDate = new Date(currentYear, currentMonth, day);
        eventDayElement.innerHTML = eventDate.toLocaleString("en-US", {weekday: "long"});
        eventDateElement.innerHTML = `, ${months[currentMonth]} ${day}`;
    }
}
