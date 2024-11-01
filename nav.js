document.addEventListener("DOMContentLoaded", function() {
    var nav = `
    <nav>
        <ul>
<li><a href="home.html">Home</a></li>

<!-- Term Links -->
<li><a href="T1.html">Term 1</a></li>
<li><a href="Term2.html">Term 2</a></li>
<li><a href="Term3.html">Term 3</a></li>

<!-- Doctor and Appointments -->
<li><a href="doctor-schedule.html">Doctor Schedule</a></li>
<li><a href="appointments.php">Confirmed Appointments</a></li>
<li><a href="index.html">Book Office Hours</a></li>

<!-- Student and Resources -->
<li><a href="Student Center Announcements.html">Student Announcements</a></li>
<li><a href="Add-A.html">Electronic Registration</a></li>
<li><a href="Page 1 - project web devolopment.html">Resources Guide</a></li>
<li><a href="Page 2 - Project Web Devolopment.html">Resources Guide by Branch</a></li>

<!-- Other -->
<li><a href="Rse.html">RSE (Research and Student Exchange)</a></li>

        </ul>
    </nav>
    `;
    document.body.insertAdjacentHTML('afterbegin', nav);
});