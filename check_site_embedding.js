window.onload = function () { check_site_embedding(); }
function extractHost(u) { try { var p = u.href.split('/'); return p[0] + '://' + p[2]; } catch (e) { return 'x'; } return 'y'; }
// func referenced from: https://www.idealhealthfacility.org.za/
if (extractHost(top.location) != extractHost(self.location)) {
    top.location.replace(self.location.href);
    setTimeout("if (extractHost(top.location) != extractHost(self.location)) {alert('Warning the systen has been maliciously embedded on this page');}", 10000);
}