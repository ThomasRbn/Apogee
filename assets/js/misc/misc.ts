export function isJsonEmpty(json) {
    return !json || Object.keys(json).length === 0;
}