import matplotlib.pyplot as plt
import numpy as np


num_files_50, time_50  = np.loadtxt('50.txt', usecols=range(0,2),unpack=True) 
num_files_100, time_100  = np.loadtxt('100.txt', usecols=range(0,2),unpack=True) 
num_files_200, time_200  = np.loadtxt('200.txt', usecols=range(0,2),unpack=True) 
num_files_400, time_400  = np.loadtxt('400.txt', usecols=range(0,2),unpack=True) 
num_files_1000, time_1000  = np.loadtxt('1000.txt', usecols=range(0,2),unpack=True) 
num_files_5000, time_5000  = np.loadtxt('5000.txt', usecols=range(0,2),unpack=True) 
# num_files_10000, time_10000  = np.loadtxt('10000.txt', usecols=range(0,2),unpack=True) 


plt.plot(num_files_50[1:], time_50[1:], label = "Trans. size 50")
plt.plot(num_files_100[1:], time_100[1:], label = "Trans. size 100")
plt.plot(num_files_200[1:], time_200[1:], label = "Trans. size 200")
plt.plot(num_files_400[1:], time_400[1:], label = "Trans. size 400")

plt.xlabel("Total number of pages created")
plt.ylabel("Pages created per second")
# plt.plot(num_files_1000, time_1000, label = "Trans. size 1000")
# plt.plot(num_files_5000, time_5000, label = "Trans. size 5000")
plt.legend()
plt.show()




num_files_50_gb, time_50_gb  = np.loadtxt('50_gb_collector.txt', usecols=range(0,2),unpack=True) 
num_files_200_gb, time_200_gb  = np.loadtxt('200_gb_collector.txt', usecols=range(0,2),unpack=True) 
num_files_400_gb, time_400_gb  = np.loadtxt('400_gb_collector.txt', usecols=range(0,2),unpack=True) 
num_files_1000_gb, time_1000_gb  = np.loadtxt('1000_gb_collector.txt', usecols=range(0,2),unpack=True) 


# plt.plot(num_files_50_gb[1:], time_50_gb[1:], label = "Trans. size 50 w/ gb collector")
# plt.plot(num_files_200_gb[1:], time_200_gb[1:], label = "Trans. size 200 w/ gb collector")
# plt.plot(num_files_400_gb[1:], time_400_gb[1:], label = "Trans. size 400 w/ gb collector")
# plt.plot(num_files_1000_gb[1:], time_1000_gb[1:], label = "Trans. size 1000 w/ gb collector")

# plt.xlabel("Total number of pages created")
# plt.ylabel("Pages created per second")

# plt.legend()
# plt.show()


