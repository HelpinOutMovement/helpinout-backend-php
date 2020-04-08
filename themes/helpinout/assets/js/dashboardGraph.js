// knob chart js
$(function () {
    /* jQueryKnob */

    $(".knob").knob({
        /*change : function (value) {
         //console.log("change : " + value);
         },
         release : function (value) {
         console.log("release : " + value);
         },
         cancel : function () {
         console.log("cancel : " + this.value);
         },*/
        draw: function () {

            // "tron" case
            if (this.$.data('skin') == 'tron') {

                var a = this.angle(this.cv)  // Angle
                        , sa = this.startAngle          // Previous start angle
                        , sat = this.startAngle         // Start angle
                        , ea                            // Previous end angle
                        , eat = sat + a                 // End angle
                        , r = true;

                this.g.lineWidth = this.lineWidth;

                this.o.cursor
                        && (sat = eat - 0.3)
                        && (eat = eat + 0.3);

                if (this.o.displayPrevious) {
                    ea = this.startAngle + this.angle(this.value);
                    this.o.cursor
                            && (sa = ea - 0.3)
                            && (ea = ea + 0.3);
                    this.g.beginPath();
                    this.g.strokeStyle = this.previousColor;
                    this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sa, ea, false);
                    this.g.stroke();
                }

                this.g.beginPath();
                this.g.strokeStyle = r ? this.o.fgColor : this.fgColor;
                this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sat, eat, false);
                this.g.stroke();

                this.g.lineWidth = 2;
                this.g.beginPath();
                this.g.strokeStyle = this.o.fgColor;
                this.g.arc(this.xy, this.xy, this.radius - this.lineWidth + 1 + this.lineWidth * 2 / 3, 0, 2 * Math.PI, false);
                this.g.stroke();

                return false;
            }
        }
    });


});


// donut chart js

(function () {
    var donut = new Morris.Donut({
        element: 'sales-chart',
        resize: true,
        colors: ["#0073b7", "#00a65a", "#00c0ef", "#f39c12", "rgb(245, 105, 84)"],
        data: [
            {label: "5 Star Facilities", value: 30},
            {label: "4 Star Facilities", value: 25},
            {label: "3 Star Facilities", value: 20},
            {label: "2 Star Facilities", value: 15},
            {label: "1 Star Facilities", value: 18}

        ],
        hideHover: 'auto'
    });
})();