import "./bootstrap";

// Importar Chart.js y plugins
import Chart from "chart.js/auto";
import ChartDataLabels from "chartjs-plugin-datalabels";
// Si no usas el de gradiente, puedes comentar esta línea
import ChartGradient from "chartjs-plugin-gradient";

// Registrar plugins
Chart.register(ChartDataLabels, ChartGradient);

// Hacer Chart global
window.Chart = Chart;

// === Alpine.js ===
import Alpine from "alpinejs";

window.Alpine = Alpine;
Alpine.start();
