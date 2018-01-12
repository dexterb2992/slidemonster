import {showSuccessMsg, showErrorMsg} from './helper';

export default {
	state: {
		success: null,
		error: null
	},
	setSuccess(message) {
		showSuccessMsg(message);
		// this.state.success = message
		// setTimeout(() => {
		// 	this.removeSuccess()
		// }, 3000);

	},
	setError(message) {
		showErrorMsg(message);
		// this.state.error = message
		// setTimeout(() => {
		// 	this.removeError()
		// }, 6000);
	},
	removeSuccess() {
		this.state.success = null
	},
	removeError() {
		this.state.error = null
	}
}
