<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3';
import { ref, onMounted } from 'vue';
import * as echarts from 'echarts';
import { useUrlStore } from '@/stores/urlStore';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const urlStore = useUrlStore();
const page = usePage();

console.log('Page props:', page.props.shortUrls);


const chartContainer = ref(null);
let chart = null;

const initChart = () => {
  if (!chartContainer.value) return;

  if (!chart) {
    chart = echarts.init(chartContainer.value);
  }

  const labels = urlStore.shortUrls.map(url => url.title);
  const data = urlStore.shortUrls.map(url => url.clicks);

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
        rotate: 45, 
        formatter: (value) => {
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

// const fetchUrls = async (url) => {
//   await urlStore.fetchShortUrls(url);
// };

onMounted(async () => {
  await urlStore.fetchShortUrls();

  initChart();

  window.addEventListener('resize', () => {
    if (chart) {
      chart.resize();
    }
  });
});

</script>

<template>
    <Head title="Analytics" />
  <AuthenticatedLayout>
    <main class="w-full min-h-screen bg-white p-8 py-16 px-4 flex flex-col items-center">
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
            <!-- <tr v-for="shortUrl in urlStore.shortUrls" :key="shortUrl.id"> -->
            <tr v-for="shortUrl in page.props.shortUrls.data" :key="shortUrl.id">
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

         <!-- Pagination -->
         <div class="mt-8 flex justify-center items-center">
                <Link v-if="page.props.shortUrls.prev_page_url" :href="$page.props.shortUrls.first_page_url" class="mr-2 py-2">
                    <font-awesome-icon icon="angles-left" class="text-lg text-gray-300 hover:text-gray-400" />
                </Link>
                <Link v-if="page.props.shortUrls.prev_page_url" :href="$page.props.shortUrls.prev_page_url" class="mr-2 px-4 py-2">
                    <font-awesome-icon icon="chevron-left" class="text-lg text-gray-300 hover:text-gray-400" />
                </Link>

                <p>{{ page.props.shortUrls.current_page }} of {{ page.props.shortUrls.last_page }}</p>

                <Link v-if="page.props.shortUrls.next_page_url" :href="$page.props.shortUrls.next_page_url" class="ml-2 px-4 py-2">
                    <font-awesome-icon icon="chevron-right" class="text-lg text-gray-300 hover:text-gray-400" />
                </Link>
                <Link v-if="page.props.shortUrls.next_page_url" :href="$page.props.shortUrls.last_page_url" class="ml-2 py-2">
                    <font-awesome-icon icon="angles-right" class="text-lg text-gray-300 hover:text-gray-400" />
                </Link>
            </div>
      </div>
    </main>
  </AuthenticatedLayout>
</template>
