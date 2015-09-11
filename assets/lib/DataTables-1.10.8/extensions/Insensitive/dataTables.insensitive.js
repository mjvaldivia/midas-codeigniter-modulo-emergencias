/* global jQuery */
jQuery.fn.DataTable.ext.type.search.string = function (data) {
	if (!data) return "";
	if (typeof data === "string") {
		data = data.replace(/á/gi, "a")
			.replace(/é/gi, "e")
			.replace(/í/gi, "i")
			.replace(/ó/gi, "o")
			.replace(/ú/gi, "u")
			.replace(/à/gi, "a")
			.replace(/è/gi, "e")
			.replace(/ì/gi, "i")
			.replace(/ò/gi, "o")
			.replace(/ù/gi, "u")
			.replace(/ñ/gi, "n");
	}
	return data;
};
					
jQuery.fn.DataTable.ext.type.order["html-pre"] = function(data) {
	if (!data || data === "-") return "";
	data = data.replace ? data.replace(/<.*?>/g, "").toLowerCase() : a + "";
	data = data.replace(/á/gi, "a")
		.replace(/é/gi, "e")
		.replace(/í/gi, "i")
		.replace(/ó/gi, "o")
		.replace(/ú/gi, "u")
		.replace(/à/gi, "a")
		.replace(/è/gi, "e")
		.replace(/ì/gi, "i")
		.replace(/ò/gi, "o")
		.replace(/ù/gi, "u")
		.replace(/ñ/gi, "n");
		
	return data;
};

jQuery.fn.DataTable.ext.type.order["string-pre"] = function(data) {
	if (!data || data === "-") return "";
	if (!data.toString) return "";
	
	if (typeof data === "string") {
		data = data.toLowerCase();
		
		data = data.replace(/á/gi, "a")
			.replace(/é/gi, "e")
			.replace(/í/gi, "i")
			.replace(/ó/gi, "o")
			.replace(/ú/gi, "u")
			.replace(/à/gi, "a")
			.replace(/è/gi, "e")
			.replace(/ì/gi, "i")
			.replace(/ò/gi, "o")
			.replace(/ù/gi, "u")
			.replace(/ñ/gi, "n");
	}
	return data;
};