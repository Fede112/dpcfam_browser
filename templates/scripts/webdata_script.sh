## Main script ##

# clean hmm
sed -i 's/_cdhit.fasta//' lt1000_001_1.hmm

# create an hmm file per cluster
awk '$1=="NAME"{file=$2; print header > "./hmms/"file".hmm"}1{if($0 ~ "HMMER3/f"){header=$0;}print $0 > "./hmms/"file".hmm"}' lt1000_001_1.hmm

# divide into 5 folders each of 10k MCs each (ordered)
for file in *.hmm; do mcid=${file/.hmm/}; mcid=${mcid/MC/}; if [ $mcid -gt 500000 ]; then dir_num=5; else dir_num=$((mcid/100000 + 1)); fi ; mv $file "./dir_"$dir_num; done

for file in *.fasta; do mcid=${file/_cdhit.fasta/}; mcid=${mcid/MC/}; if [ $mcid -gt 500000 ]; then dir_num=5; else dir_num=$((mcid/100000 + 1)); fi ; mv $file "./dir_"$dir_num; done


## Auxiliary ##

# clean a directory
{
for file in *; do
    mcid=${file/_cdhit.fasta/}; 
    mcid=${mcid/MC/};
    if ! grep -qxFe "${mcid}" ../MC_lt1000_001_1_list; then
        # echo "Deleting: $file  $mcid"
        # the next line is commented out.  Test it.  Then uncomment to remove the files
        rm "$file"
    fi
done;
}

# population + avglen

awk '{count[$4]+=1;len[$4]+=($3-$2+1); len2[$4]+=($3-$2+1)**2}END{for(mc in count) print mc, count[mc], len[mc]/count[mc], sqrt( (len2[mc]/count[mc]) - (len[mc]/count[mc])**2) }' sequence-labeled_filtered_all.txt > MCpop_avglen.txt


# make zip file (files inside dir_1: dir_2; dir_3; dir_4; dir_5).
# find -j adds the files but ignores the paths
find . -name *.hmm -print | zip -j dpcfam_hmms.zip -@
