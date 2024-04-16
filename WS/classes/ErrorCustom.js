class ErrorCustom {
    static errorNotFound() {
        return {
            error_message: 'Method not found',
            error_code: 1
        }
    }
    static errorAuthorization() {
        return {
            error_message: 'Error authorization',
            error_code: 2
        }
    }
    static errorMessage() {
        return {
            error_message: 'Error, message is null',
            error_code: 3
        }
    }
}
export default ErrorCustom