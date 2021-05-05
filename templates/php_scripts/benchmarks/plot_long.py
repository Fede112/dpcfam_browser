import matplotlib.pyplot as plt
import numpy as np

num_files_200, time_200  = np.loadtxt('200_long.txt', usecols=range(0,2),unpack=True) 
num_files_200_gb, time_200_gb  = np.loadtxt('200_long_gb.txt', usecols=range(0,2),unpack=True) 
num_files_200_ryan_all, time_200_ryan_all  = np.loadtxt('200_long_ryan_all.txt', usecols=range(0,2),unpack=True) 


plt.plot(num_files_200[1:], time_200[1:], label = "Trans. size 200")
plt.plot(num_files_200_gb[1:], time_200_gb[1:], label = "Trans. size 200 with gb collector")
plt.plot(num_files_200_ryan_all[1:], time_200_ryan_all[1:], label = "Trans. size 200 - ryan_all opt")

plt.xlabel("Total number of pages created")
plt.ylabel("Pages created per second")
plt.legend()
plt.show()