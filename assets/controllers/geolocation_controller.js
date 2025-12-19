import { Controller } from '@hotwired/stimulus';

// Handles browser geolocation and redirects to the localisation route.
export default class extends Controller {
    static values = {
        url: String, // Base URL for the localisation route, e.g. "/localisation"
    }

    getLocation(event) {
        event.preventDefault();

        if (!('geolocation' in navigator)) {
            this.notify('La géolocalisation n\'est pas supportée par votre navigateur.');
            return;
        }

        navigator.geolocation.getCurrentPosition(
            this.#onSuccess.bind(this),
            this.#onError.bind(this),
            { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
        );
    }

    #onSuccess(position) {
        const lat = position.coords.latitude;
        const lng = position.coords.longitude;

        const base = this.hasUrlValue ? this.urlValue : '/localisation';
        const url = new URL(base, window.location.origin);
        url.searchParams.set('latitude', String(lat));
        url.searchParams.set('longitude', String(lng));

        window.location.assign(url.toString());
    }

    #onError(err) {
        // Better user-friendly message with reason when available
        let message = 'Impossible de récupérer votre position.';
        if (err && typeof err.message === 'string' && err.message.length > 0) {
            message += `\nRaison: ${err.message}`;
        }
        this.notify(message);
    }

    notify(msg) {
        // Basic fallback
        // In the future, this could be replaced by a toast component
        alert(msg);
    }
}
