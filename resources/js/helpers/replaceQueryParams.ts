export function replaceQueryParams(paramsToReplace: { [key: string]: string }): string {
    // Get the current query parameters
    const urlSearchParams = new URLSearchParams(window.location.search);
    const currentParams = Object.fromEntries(urlSearchParams.entries());

    // Replace the specified parameters
    for (const key in paramsToReplace) {
        if (paramsToReplace[key] == '')
            delete currentParams[key];
        else
            currentParams[key] = paramsToReplace[key];
    }

    // Rebuild the query string
    const newQueryString = new URLSearchParams(currentParams).toString();

    // Replace the current query string with the new one
    const newUrl = `?${newQueryString}`;
    return newUrl;
}
