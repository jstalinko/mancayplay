import { ref, onMounted } from 'vue';

export function useTheme() {
    const isDark = ref(false);

    const updateHtmlClass = (dark) => {
        if (dark) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    };

    const toggleTheme = () => {
        isDark.value = !isDark.value;
        localStorage.setItem('theme', isDark.value ? 'dark' : 'light');
        updateHtmlClass(isDark.value);
    };

    const initTheme = () => {
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme) {
            isDark.value = savedTheme === 'dark';
        } else {
            isDark.value = window.matchMedia('(prefers-color-scheme: dark)').matches;
        }
        updateHtmlClass(isDark.value);

        // Watch for system preference changes
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
            if (!localStorage.getItem('theme')) {
                isDark.value = e.matches;
                updateHtmlClass(isDark.value);
            }
        });
    };

    return {
        isDark,
        toggleTheme,
        initTheme,
    };
}
