/*
* @copyright (c) 2008 Nicolo John Davis and Sarang Bharadwaj
* @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

#include <iostream>
#include <unistd.h>
#include <fcntl.h>
#include <cstdlib>
#include <sys/wait.h>
#include <signal.h>
#include <fstream>
#include <string>
#define RIGHT 0
#define WRONG 2
#define TIME_EXCEEDED 3
#define COMPILE_ERROR 1
#define ILLEGAL_FILE 4
#define TIME_LIMIT 2

using namespace std;
int exit_status,pid;
char comm[100];

#ifdef DEBUG
	string err[]={"right","compile err","wrong","time excd","illegal file"};
#endif

void time_out(int i)
{
	sprintf(comm,"kill -s9 %d",pid);
	system(comm);
	
	#ifdef DEBUG
		cerr<<err[TIME_EXCEEDED]<<endl;
	#endif

	exit(TIME_EXCEEDED);
}

string getpath(string s)
{
	int i = s.find_last_of('/');
	if(i != string::npos)
		return s.substr(0, i);
	return "";
}

string getext(string s)
{
	int i = s.find_last_of('.');
	if(i != string::npos)
		return s.substr(i+1);
	return "";
}

int main(int argc,char *argv[])
{
	string ext = getext(argv[1]);
	string path = getpath(argv[1]);

	if(ext=="" || path=="" || (ext!="cpp" && ext!="c" && ext!="CPP" && ext!="C"))
	{
		#ifdef DEBUG
			cerr<<err[ILLEGAL_FILE]<<endl;
		#endif

		return ILLEGAL_FILE;
	}

	string flag=" ";
	if(ext.size() == 1)
		flag = " -xc ";

	string cmd = "g++ -lm "+flag+string(argv[1])+"  -o"+path+"/a.out 2> /dev/null";
	
	#ifdef DEBUG
		cerr<<cmd<<" "<<path<<" "<<ext<<endl;
	#endif

	int i = system(cmd.c_str());
	if(i)
	{
		#ifdef DEBUG
			cerr<<err[COMPILE_ERROR]<<endl;
		#endif
		return COMPILE_ERROR;
	}

	pid=fork();
	if(pid)
	{
		signal(SIGALRM,time_out);
		alarm(TIME_LIMIT);
		waitpid(pid,NULL,0);
		alarm(0);
		
		string file = path+"/op";
		ifstream f1(file.c_str());
		
		file = "./problems/"+string(argv[2])+"/out";
		ifstream f2(file.c_str());

		string s="",b1,b2;
		while(1)
		{
			f1>>s;
			if(!s[0])
				break;
			b1 = b1+" "+s;
			s[0]=0;
		}
		s="";
		while(1)
		{
			f2>>s;
			if(!s[0])
				break;
			b2 = b2+" "+s;
			s[0]=0;
		}

		if(b1==b2)
			exit_status=RIGHT;
		else
			exit_status=WRONG;
	}
	
	else
	{
		int inp = dup(0);
		int op = dup(1);


		string file;
		file = path+"/op";
		int ofid=open(file.c_str(),O_RDWR|O_CREAT|O_TRUNC,0666);
		dup2(ofid,1);
		
		file = "./problems/"+string(argv[2])+"/in";
		int ifid=open(file.c_str(),O_RDONLY,0);
		dup2(ifid,0);
		
		file=path+"/a.out";
		execv(file.c_str(),NULL);

		dup2(inp,0);
		dup2(op,1);
		return 0;
	}

	#ifdef DEBUG
		cerr<<err[exit_status]<<endl;
	#endif
	return exit_status;	
}
