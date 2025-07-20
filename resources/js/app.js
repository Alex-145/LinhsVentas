import "./bootstrap";

// Importar Chart.js y plugins
import Chart from "chart.js/auto";
import ChartDataLabels from "chartjs-plugin-datalabels";
import ChartGradient from "chartjs-plugin-gradient";

// Registrar plugins
Chart.register(ChartDataLabels, ChartGradient);

// Hacer Chart global (opcional, útil si usas scripts inline en Blade)
window.Chart = Chart;
