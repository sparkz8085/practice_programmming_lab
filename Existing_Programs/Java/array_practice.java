import java.util.*;
public class array_practice
{
	public static void main(String args[])
	{
		
		Scanner sc=new Scanner(System.in);
		System.out.println("enter the size of an array");
		int size=sc.nextInt();
		int arr[]=new int[size];
		int podd[]=new int[size];
		int peven[]=new int[size];
		int nodd[]=new int[size];
		int neven[]=new int[size];
		int k=0, j=0, m=0, n=0;
		for(int i=0;i<size;i++)
		{
			System.out.println("enter the values"+(i+1));
			arr[i]=sc.nextInt();
		}
		for (int i=0;i<size;i++)
		{
			System.out.println("entered array");
			System.out.print(arr[i]+",");
		}
		for (int i=0;i<size;i++)
		{
			if (arr[i]%2==0 && arr[i]>0)
			{
				System.out.println(peven[k++]=arr[i]+"are positive no.\n");			
			}
			else if(arr[i]%2==0 && arr[i]<0)
			{
				System.out.println(neven[j++]=arr[i]+"are negetive even no. \n");
			}		
			else if(arr[i]%2!=0 && arr[i]>0)
			{
				System.out.println(podd[m++]=arr[i]+"are positive odd no. \n");
			}
			else
			{
				System.out.println(nodd[n++]=arr[i]+"are negetive odd no.");
			}
		}
	}
}

