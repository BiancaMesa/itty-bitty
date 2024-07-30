<script setup>
import { ref, onMounted } from 'vue';
import * as echarts from 'echarts';
import { useUrlStore } from '@/stores/urlStore';

const urlStore = useUrlStore();

// Reference to the ECharts container
const chartContainer = ref(null);
let chart = null; 

// Function to initialize and update the chart
const initChart = () => {
  if (!chartContainer.value) return;

  // Initialize ECharts or get the existing instance
  if (!chart) {
    chart = echarts.init(chartContainer.value);
  }

  // Prepare data for the chart
  const labels = urlStore.shortUrls.map(url => url.title);
  const data = urlStore.shortUrls.map(url => url.clicks);

  // Set chart options
  const options = {
    title: {
      text: 'Number of Clicks per URL',
    },
    tooltip: {
      trigger: 'item',
    },
    xAxis: {
      type: 'category',
      data: labels,
      axisLabel: {
        rotate: 45, // Labels will appear rotated
        formatter: (value) => {
          // Truncate the URL for display purposes with an ellipsis
          return value.length > 50 ? `${value.substring(0, 50)}...` : value;
        },
      },
    },
    yAxis: {
      type: 'value',
    },
    series: [
      {
        name: 'Clicks',
        type: 'bar',
        data: data,
        itemStyle: {
          color: '#42A5F5',
        },
      },
    ],
  };

  // Set the options and render the chart
  chart.setOption(options);
};

// Initialize the chart and set up watchers
onMounted(async () => {
  await urlStore.fetchShortUrls();

  // Initialize the chart
  initChart();

  // Handle window resize events
  window.addEventListener('resize', () => {
    if (chart) {
      chart.resize();
    }
  });

  console.log('shortUrls is:', urlStore.shortUrls);
  console.log('Index 0 array is:', urlStore.shortUrls[0]);
  console.log('Latest short url:', urlStore.latestFullShortenedUrl);
});

</script>

<template>
  <section class="w-full min-h-screen bg-white p-8 py-16 px-4 flex flex-col items-center">
    <h1 class="text-3xl font-bold mb-4 text-sky-800">URL Analytics</h1>

    <!-- ECharts Container -->
    <div ref="chartContainer" class="w-full h-64 sm:h-80 md:h-96 lg:h-[500px] flex justify-center">
    </div>


    <!-- Table -->
    <div class="overflow-x-auto mt-10 w-full max-w-4xl">
      <table class="w-full bg-white border border-gray-200 mt-8 text-sm">
        <thead class="bg-sky-100">
          <tr>
            <th class="py-2 px-4 border-b text-left">Name</th>
            <th class="py-2 px-4 border-b text-left">Original URL</th>
            <th class="py-2 px-4 border-b text-left">Shortened URL</th>
            <th class="py-2 px-4 border-b text-left">Clicks</th>
          </tr>
        </thead>
        <tbody class="bg-white text-sm">
          <tr v-for="shortUrl in urlStore.shortUrls" :key="shortUrl.id">
            <td class="py-2 px-4 border-b break-words">{{ shortUrl.title }}</td>
            <td class="py-2 px-4 border-b break-words">{{ shortUrl.original_url }}</td>
            <td class="py-2 px-4 border-b break-words">
              <a :href="shortUrl.full_shortened_url" target="_blank" rel="noopener noreferrer">
                {{ shortUrl.full_shortened_url }}
              </a>
            </td>
            <td class="py-2 px-4 border-b">{{ shortUrl.clicks }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </section>
</template>
