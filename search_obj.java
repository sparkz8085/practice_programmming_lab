import java.util.*;
public class search_obj
{
	int i,lb=0,ub=9,p=0,k=0,ns=0;
	new_input(int x,y,z,m,n,o;)
	{
		i=x;
		lb=y;
		ub=z;
		p=m;
		k=n;
		ns=o;
	}
	int get_intput()
	{
		int m[ ]=new int[10];
        	Scanner in = new Scanner(System.in);
        	System.out.println ("Enter the numbers in the array: ");
        	for(i=0;i<10;i++)
        	{
            		m[i]=in.nextInt();
        	}
        	System.out.println ("Enter the number to be searched:");
        	ns= in.nextInt();
	}
	void search_func()
	{
        	while(lb<=ub)
        	{
            		p=(lb+ub)/2;
            		if(m[p]<ns)
                		lb=p+1;
            		if(m[p]>ns)
               			ub=ub-1;
            		if(m[p]==ns)
            		{
                		k=1;
                		break;
            		}
        	}
        	if(k==1)
            System.out.println ("Search Successful");
        else
            System.out.println ("The number is not present");
	}
	public static void main(String args[])
	{
		
	}
}		
		
		
