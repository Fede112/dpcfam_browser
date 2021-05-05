import matplotlib.pyplot as plt
import numpy as np

# num_files_200, time_200  = np.loadtxt('200_long.txt', usecols=range(0,2),unpack=True) 
num_files_200_ryan_baseline, time_200_ryan_baseline  = np.loadtxt('200_ryan_baseline.txt', usecols=range(0,2),unpack=True) 
num_files_200_ryan_name, time_200_ryan_name  = np.loadtxt('200_ryan_name.txt', usecols=range(0,2),unpack=True) 

num_files_200_ryan_1, time_200_ryan_1  = np.loadtxt('200_ryan_1.txt', usecols=range(0,2),unpack=True) 
num_files_200_ryan_1_uncache, time_200_ryan_1_uncache  = np.loadtxt('200_ryan_1_uncache.txt', usecols=range(0,2),unpack=True) 
num_files_200_ryan_1_gb, time_200_ryan_1_gb  = np.loadtxt('200_ryan_1_gb.txt', usecols=range(0,2),unpack=True) 

num_files_200_ryan_2, time_200_ryan_2  = np.loadtxt('200_ryan_2.txt', usecols=range(0,2),unpack=True) 
num_files_200_ryan_2_uncache, time_200_ryan_2_uncache  = np.loadtxt('200_ryan_2_uncache.txt', usecols=range(0,2),unpack=True) 
num_files_200_ryan_2_gb, time_200_ryan_2_gb  = np.loadtxt('200_ryan_2_gb.txt', usecols=range(0,2),unpack=True) 

# plt.plot(num_files_200[1:], time_200[1:], label = "Trans. size 200")


plt.plot(num_files_200_ryan_baseline[1:], time_200_ryan_baseline[1:], label = "baseline")
# plt.plot(num_files_200_ryan_name[1:], time_200_ryan_name[1:], label = "Trans. size 200 name")

# plt.plot(num_files_200_ryan_1[1:], time_200_ryan_1[1:], label = "Trans. size 200 1")
# plt.plot(num_files_200_ryan_1_uncache[1:], time_200_ryan_1_uncache[1:], label = "Trans. size 200 - ryan_1_uncache")
plt.plot(num_files_200_ryan_1_gb[1:], time_200_ryan_1_gb[1:], label = "1. $template outside loop")

# plt.plot(num_files_200_ryan_2[1:], time_200_ryan_2[1:], label = "baseline")
# plt.plot(num_files_200_ryan_2_uncache[1:], time_200_ryan_2_uncache[1:], label = "$pages->uncacheAll() every 200 pages")
plt.plot(num_files_200_ryan_2_gb[1:], time_200_ryan_2_gb[1:], label = "2. $parent outside loop")


plt.xlabel('''Total number of pages created

Figure 1: All tests were done with a new transaction+gc_collect_cycles() every 200 pages created.''')
plt.ylabel("Pages created per second")
plt.legend()

plt.tight_layout()
plt.show()