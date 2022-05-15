/**
 *
 * @param {*} error
 * @returns string
 */
export function handleErrorAxios(error) {
	console.log(error);
	if (error.response) {
		return JSON.stringify(error.response.data);
	} else if (error.request) {
		return JSON.stringify(error.request);
	} else {
		return error.message;
	}
	return JSON.stringify(error.config);
}
