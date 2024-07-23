<script setup>
  import { ref, onMounted } from 'vue';
  import * as echarts from 'echarts';
  import { usePage } from '@inertiajs/vue3';
  
  // Get the props from back
  const { props } = usePage();
  const shortUrls = props.shortUrls || [];
  
  // Reference to the ECharts container
  const chartContainer = ref(null);
  
  onMounted(() => {
    // We initialize ECharts
    const chart = echarts.init(chartContainer.value);
  
    // We prepare data for the chart
    //the array with the original urls
    const labels = shortUrls.map(url => url.original_url); 
    const data = shortUrls.map(url => url.clicks);
  
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
          rotate: 70, //labels will appear rotated 
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
  });
  </script>

<template>
    <main class="w-screen h-screen bg-sky-50 p-8 flex flex-col items-center">
      <h1 class="text-2xl font-bold mb-4">URL Analytics</h1>
  
      <!-- ECharts Container with defined height and width-->
      <div ref="chartContainer" class="w-full h-80 flex self-center justify-content md:h-96 lg:h-[500px]">

      </div>
  
      <div class="overflow-x-auto mt-10">
        <table class="w-96 bg-white border border-gray-200 mt-8">
        <thead>
          <tr>
            <th class="py-2 px-4 border-b text-left">Original URL</th>
          <th class="py-2 px-4 border-b text-left">Shortened URL</th>
          <th class="py-2 px-4 border-b text-left">Clicks</th>
          </tr>
        </thead>
        <tbody class="min-w-full bg-white border border-gray-200 mt-8 text-sm">
          <tr v-for="shortUrl in shortUrls" :key="shortUrl.id">
            <td class="py-2 px-4 border-b">{{ shortUrl.original_url }}</td>
            <td class="py-2 px-4 border-b">
              <a :href="shortUrl.full_shortened_url" target="_blank" rel="noopener noreferrer">
                {{ shortUrl.full_shortened_url }}
              </a>
            </td>
            <td class="py-2 px-4 border-b">{{ shortUrl.clicks }}</td>
          </tr>
        </tbody>
      </table>
      </div>
      
    </main>
  </template>
  
  
