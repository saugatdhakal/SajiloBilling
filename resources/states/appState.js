import { defineStore } from 'pinia';

export const appState = defineStore('Appication State', {
    state: () => ({
        themeDark: true,
    }),
    actions: {
        toggleTheme() {
            this.themeDark = !this.themeDark;
        }
    }
}
);
