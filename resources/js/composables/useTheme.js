import { computed, onMounted, ref, watch } from 'vue';

const STORAGE_KEY = 'shop-theme';
const theme = ref('light');

const applyTheme = (value) => {
    if (typeof document === 'undefined') {
        return;
    }

    document.documentElement.classList.toggle('dark', value === 'dark');
};

export const useTheme = () => {
    const isDark = computed(() => theme.value === 'dark');

    const toggleTheme = () => {
        theme.value = isDark.value ? 'light' : 'dark';
    };

    onMounted(() => {
        const storedTheme = localStorage.getItem(STORAGE_KEY);
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

        theme.value = storedTheme ?? (prefersDark ? 'dark' : 'light');
        applyTheme(theme.value);
    });

    watch(theme, (value) => {
        localStorage.setItem(STORAGE_KEY, value);
        applyTheme(value);
    });

    return {
        theme,
        isDark,
        toggleTheme,
    };
};
