/**
 * Created by claudio on 22-09-15.
 */
/**
 * Created by claudio on 22-06-15.
 */
var GeoEncoder = {
    datum: null,
    eccSquared: null,
    a: null,
    K0: 0.9996,

    initParams: function () {
        this.datum = this.datum || "ETRS89";
        switch (this.datum) {
            case 'Airy':
                this.a = 6377563;
                this.eccSquared = 0.00667054;
                break;
            case 'Australian National':
                this.a = 6378160;
                this.eccSquared = 0.006694542;
                break;
            case 'Bessel 1841':
                this.a = 6377397;
                this.eccSquared = 0.006674372;
                break;
            case 'Bessel 1841 Nambia':
                this.a = 6377484;
                this.eccSquared = 0.006674372;
                break;
            case 'Clarke 1866':
                this.a = 6378206;
                this.eccSquared = 0.006768658;
                break;
            case 'Clarke 1880':
                this.a = 6378249;
                this.eccSquared = 0.006803511;
                break;
            case 'Everest':
                this.a = 6377276;
                this.eccSquared = 0.006637847;
                break;
            case 'Fischer 1960 Mercury':
                this.a = 6378166;
                this.eccSquared = 0.006693422;
                break;
            case 'Fischer 1968':
                this.a = 6378150;
                this.eccSquared = 0.006693422;
                break;
            case 'GRS 1967':
                this.a = 6378160;
                this.eccSquared = 0.006694605;
                break;
            case 'GRS 1980':
                this.a = 6378137;
                this.eccSquared = 0.00669438;
                break;
            case 'Helmert 1906':
                this.a = 6378200;
                this.eccSquared = 0.006693422;
                break;
            case 'Hough':
                this.a = 6378270;
                this.eccSquared = 0.00672267;
                break;
            case 'International':
                this.a = 6378388;
                this.eccSquared = 0.00672267;
                break;
            case 'Krassovsky':
                this.a = 6378245;
                this.eccSquared = 0.006693422;
                break;
            case 'Modified Airy':
                this.a = 6377340;
                this.eccSquared = 0.00667054;
                break;
            case 'Modified Everest':
                this.a = 6377304;
                this.eccSquared = 0.006637847;
                break;
            case 'Modified Fischer 1960':
                this.a = 6378155;
                this.eccSquared = 0.006693422;
                break;
            case 'South American 1969':
                this.a = 6378160;
                this.eccSquared = 0.006694542;
                break;
            case 'WGS 60':
                this.a = 6378165;
                this.eccSquared = 0.006693422;
                break;
            case 'WGS 66':
                this.a = 6378145;
                this.eccSquared = 0.006694542;
                break;
            case 'WGS 72':
                this.a = 6378135;
                this.eccSquared = 0.006694318;
                break;
            case 'ED50':
                this.a = 6378388;
                this.eccSquared = 0.00672267;
                break;
            case 'WGS 84':
            case 'EUREF89':
            case 'ETRS89':
                this.a = 6378137;
                this.eccSquared = 0.00669438;
                break;
            default:
                return null;
        }
    },

    decimalDegreeToUtm: function (lon, lat) {
        this.initParams();

        var lonTemp = parseFloat(lon) + 180 - parseInt((parseFloat(lon) + 180) / 360) * 360 - 180;

        var latRad = this.deg2rad(parseFloat(lat));
        var lonRad = this.deg2rad(lonTemp);
        var zoneNumber = null;
        var lonOrigin = null;
        var lonOriginRad = null;
        var utmZone = null;
        var eccPrimeSquared = null;
        var N = null;
        var T = null;
        var C = null;
        var A = null;
        var M = null;
        var utmEasting = null;
        var utmNorthing = null;

        if (lonTemp >= 8 && lonTemp <= 13 && lat > 54.5 && lat < 58) {
            zoneNumber = 32;
        } else if (lat >= 56 && lat < 64 && lonTemp >= 3 && lonTemp < 12) {
            zoneNumber = 32;
        } else {
            zoneNumber = parseInt((lonTemp + 180) / 6) + 1;
            if (lat >= 72 && lat < 84) {
                if (lonTemp >= 0 && lonTemp < 9) {
                    zoneNumber = 31;
                } else if (lonTemp >= 9 && lonTemp < 21) {
                    zoneNumber = 33;
                } else if (lonTemp >= 21 && lonTemp < 33) {
                    zoneNumber = 35;
                } else if (lonTemp >= 33 && lonTemp < 42) {
                    zoneNumber = 37;
                }
            }
        }

        lonOrigin = (zoneNumber - 1) * 6 - 180 + 3;
        lonOriginRad = this.deg2rad(lonOrigin);

        utmZone = zoneNumber + this.getUtmLetterDesignator(lat);

        eccPrimeSquared = (this.eccSquared) / (1 - this.eccSquared);

        N = this.a / Math.sqrt(1 - this.eccSquared * Math.sin(latRad) * Math.sin(latRad));
        T = Math.tan(latRad) * Math.tan(latRad);
        C = eccPrimeSquared * Math.cos(latRad) * Math.cos(latRad);
        A = Math.cos(latRad) * (lonRad - lonOriginRad);

        M = this.a * ((1 - this.eccSquared / 4 - 3 * this.eccSquared * this.eccSquared / 64 - 5 * this.eccSquared * this.eccSquared * this.eccSquared / 256) * latRad - (3 * this.eccSquared / 8 + 3 * this.eccSquared * this.eccSquared / 32 + 45 * this.eccSquared * this.eccSquared * this.eccSquared / 1024) * Math.sin(2 * latRad) + (15 * this.eccSquared * this.eccSquared / 256 + 45 * this.eccSquared * this.eccSquared * this.eccSquared / 1024) * Math.sin(4 * latRad) - (35 * this.eccSquared * this.eccSquared * this.eccSquared / 3072) * Math.sin(6 * latRad));

        utmEasting = parseFloat(this.K0 * N * (A + (1 - T + C) * A * A * A / 6 + (5 - 18 * T + T * T + 72 * C - 58 * eccPrimeSquared) * A * A * A * A * A / 120) + 500000.0);

        utmNorthing = parseFloat(this.K0 * (M + N * Math.tan(latRad) * (A * A / 2 + (5 - T + 9 * C + 4 * C * C) * A * A * A * A / 24 + (61 - 58 * T + T * T + 600 * C - 330 * eccPrimeSquared) * A * A * A * A * A * A / 720)));
        if (lat < 0) {
            utmNorthing += 10000000.0;
        } //10000000 meter offset for southern hemisphere

        // Round them off, it's normally specified as integers and conversion is not terribly exact anyway
        utmNorthing = Math.round10(utmNorthing, -2);
        utmEasting = Math.round10(utmEasting, -2);

        return [utmEasting, utmNorthing, utmZone];
    },

    utmToDecimalDegree: function (utmEasting, utmNorthing, utmZone) {
        this.initParams();

        var e1 = (1 - Math.sqrt(1 - this.eccSquared)) / (1 + Math.sqrt(1 - this.eccSquared));
        var x = utmEasting - 500000.0; //remove 500,000 meter offset for longitude
        var y = utmNorthing;
        var northernHemisphere = null;
        var zoneNumber = null;
        var zoneLetter = null;
        var lonOrigin = null;
        var eccPrimeSquared = null;
        var M = null;
        var mu = null;
        var phi1Rad = null;
        var phi1 = null;
        var N1 = null;
        var T1 = null;
        var C1 = null;
        var R1 = null;
        var D = null;
        var lon = null;
        var lat = null;

        var tokens = utmZone.match(/(\d+)(\w)/i);
        zoneNumber = tokens[1];
        zoneLetter = tokens[2];

        if ('N' < zoneLetter) {
            northernHemisphere = 1;//point is in northern hemisphere
        } else {
            northernHemisphere = 0;//point is in southern hemisphere
            y -= 10000000.0;//remove 10,000,000 meter offset used for southern hemisphere
        }

        lonOrigin = (zoneNumber - 1) * 6 - 180 + 3;  //+3 puts origin in middle of zone

        eccPrimeSquared = (this.eccSquared) / (1 - this.eccSquared);

        M = y / this.K0;
        mu = M / (this.a * (1 - this.eccSquared / 4 - 3 * this.eccSquared * this.eccSquared / 64 - 5 * this.eccSquared * this.eccSquared * this.eccSquared / 256));

        phi1Rad = mu + (3 * e1 / 2 - 27 * e1 * e1 * e1 / 32) * Math.sin(2 * mu) + (21 * e1 * e1 / 16 - 55 * e1 * e1 * e1 * e1 / 32) * Math.sin(4 * mu) + (151 * e1 * e1 * e1 / 96) * Math.sin(6 * mu);
        phi1 = this.rad2deg(phi1Rad);

        N1 = this.a / Math.sqrt(1 - this.eccSquared * Math.sin(phi1Rad) * Math.sin(phi1Rad));
        T1 = Math.tan(phi1Rad) * Math.tan(phi1Rad);
        C1 = eccPrimeSquared * Math.cos(phi1Rad) * Math.cos(phi1Rad);
        R1 = this.a * (1 - this.eccSquared) / Math.pow(1 - this.eccSquared * Math.sin(phi1Rad) * Math.sin(phi1Rad), 1.5);
        D = x / (N1 * this.K0);

        lat = phi1Rad - (N1 * Math.tan(phi1Rad) / R1) * (D * D / 2 - (5 + 3 * T1 + 10 * C1 - 4 * C1 * C1 - 9 * eccPrimeSquared) * D * D * D * D / 24 + (61 + 90 * T1 + 298 * C1 + 45 * T1 * T1 - 252 * eccPrimeSquared - 3 * C1 * C1) * D * D * D * D * D * D / 720);
        lat = this.rad2deg(lat);

        lon = (D - (1 + 2 * T1 + C1) * D * D * D / 6 + (5 - 2 * C1 + 28 * T1 - 3 * C1 * C1 + 8 * eccPrimeSquared + 24 * T1 * T1) * D * D * D * D * D / 120) / Math.cos(phi1Rad);
        lon = lonOrigin + this.rad2deg(lon);
        return [lat, lon];
    },

    rad2deg: function (angulo) {
        return angulo * 57.29577951308232; // angle / Math.PI * 180
    },

    deg2rad: function (angulo) {
        return angulo * 0.017453292519943295; // (angle / 180) * Math.PI;
    },

    getUtmLetterDesignator: function (lat) {
        if ((84 >= lat) && (lat >= 72)) {
            return 'X';
        } else if ((72 > lat) && (lat >= 64)) {
            return 'W';
        } else if ((64 > lat) && (lat >= 56)) {
            return 'V';
        } else if ((56 > lat) && (lat >= 48)) {
            return 'U';
        } else if ((48 > lat) && (lat >= 40)) {
            return 'T';
        } else if ((40 > lat) && (lat >= 32)) {
            return 'S';
        } else if ((32 > lat) && (lat >= 24)) {
            return 'R';
        } else if ((24 > lat) && (lat >= 16)) {
            return 'Q';
        } else if ((16 > lat) && (lat >= 8)) {
            return 'P';
        } else if (( 8 > lat) && (lat >= 0)) {
            return 'N';
        } else if (( 0 > lat) && (lat >= -8)) {
            return 'M';
        } else if ((-8 > lat) && (lat >= -16)) {
            return 'L';
        } else if ((-16 > lat) && (lat >= -24)) {
            return 'K';
        } else if ((-24 > lat) && (lat >= -32)) {
            return 'J';
        } else if ((-32 > lat) && (lat >= -40)) {
            return 'H';
        } else if ((-40 > lat) && (lat >= -48)) {
            return 'G';
        } else if ((-48 > lat) && (lat >= -56)) {
            return 'F';
        } else if ((-56 > lat) && (lat >= -64)) {
            return 'E';
        } else if ((-64 > lat) && (lat >= -72)) {
            return 'D';
        } else if ((-72 > lat) && (lat >= -80)) {
            return 'C';
        } else {
            return 'Z';
        }
    }
};